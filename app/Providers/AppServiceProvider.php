<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use App\Models\LoanRequest;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Document;
use App\Models\ContactRequest;
use App\Models\AppointmentRequest;
use App\Models\Transfer;
use App\Services\SchemaMarkupService;
use App\Services\GoogleAdsTrackingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inject live dashboard badge counts into the layout
        View::composer('layouts.dashboard', function ($view) {
            if (!Auth::check()) return;

            $uid = Auth::id();

            $requestCount  = LoanRequest::where('user_id', $uid)
                ->whereIn('status', ['pending', 'analysis'])
                ->count();

            $unreadMessages = Message::where('user_id', $uid)
                ->where('direction', 'outbound')
                ->where('read', false)
                ->count();

            $upcomingRdv = Appointment::where('user_id', $uid)
                ->where('status', 'upcoming')
                ->count();

            $docCount = Document::where('user_id', $uid)->count();

            // Build notification feed
            $notifs = collect();
            Message::where('user_id', $uid)->where('direction', 'outbound')->where('read', false)
                ->latest()->limit(5)->get()
                ->each(fn ($m) => $notifs->push([
                    'type' => 'message',
                    'text' => __('dashboard.nav.notif_message') . ($m->subject ?? Str::limit($m->body, 50)),
                    'at'   => $m->created_at->diffForHumans(),
                    'url'  => route('dashboard.messages'),
                ]));
            LoanRequest::where('user_id', $uid)->whereIn('status', ['offer', 'analysis', 'validated', 'approved'])->latest()->limit(3)->get()
                ->each(fn ($r) => $notifs->push([
                    'type' => 'request',
                    'text' => __('dashboard.nav.notif_request', ['type' => ucwords(str_replace(['-','_'],' ',$r->loan_type)), 'status' => $r->statusLabel()]),
                    'at'   => $r->updated_at->diffForHumans(),
                    'url'  => route('dashboard.requests'),
                ]));

            $view->with([
                'navRequestCount'  => $requestCount,
                'navUnreadMessages' => $unreadMessages,
                'navUpcomingRdv'   => $upcomingRdv,
                'navDocCount'      => $docCount,
                'navNotifs'        => $notifs->sortByDesc('at')->take(6)->values(),
            ]);
        });

        // Inject live counts into the admin layout
        View::composer('layouts.admin', function ($view) {
            $view->with('adminNavStats', [
                'pending'           => LoanRequest::where('status', 'pending')->count(),
                'messages'          => Message::where('read', false)->where('direction', 'inbound')->count(),
                'appointments'      => Appointment::where('status', 'upcoming')->count(),
                'contacts'          => ContactRequest::where('handled', false)->count(),
                'rdv_requests'      => AppointmentRequest::where('handled', false)->count(),
                'pending_transfers' => Transfer::where('status', 'pending')->count(),
            ]);
        });

        // Partage SchemaMarkupService dans toutes les vues publiques
        View::composer('layouts.app', function ($view) {
            $schema  = app(SchemaMarkupService::class);
            $adsTracker = app(GoogleAdsTrackingService::class);
            $view->with([
                'schemaService'   => $schema,
                'adsTracker'      => $adsTracker,
                'adsEnabled'      => $adsTracker->isEnabled(),
            ]);
        });

        // Enregistrement singleton des services
        $this->app->singleton(SchemaMarkupService::class);
        $this->app->singleton(GoogleAdsTrackingService::class);

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)->by($request->ip());
        });

        RateLimiter::for('newsletter', function (Request $request) {
            return Limit::perHour(3)->by($request->ip());
        });

        RateLimiter::for('appointment', function (Request $request) {
            return Limit::perDay(5)->by($request->ip());
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(6)->by($request->ip());
        });
    }
}
