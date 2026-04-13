<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsletterSubscription;
use App\Models\ContactRequest;
use App\Models\AppointmentRequest;
use App\Models\Faq;
use App\Mail\ContactConfirmation;

class PageController extends Controller
{
    public function about()    { return view('pages.about'); }
    public function team()     { return view('pages.team'); }
    public function careers()  { return view('pages.careers'); }
    public function faq()
    {
        $faqsByCategory = Faq::forFaqPage();
        return view('pages.faq', compact('faqsByCategory'));
    }

    public function agencies()
    {
        $agencies = [
            ['name' => 'KapitalStark Lisboa', 'address' => 'Avenida da Liberdade, 110, 3.º andar', 'city' => 'Lisboa', 'zip' => '1269-046', 'phone' => '+351210001234', 'lat' => 38.7197, 'lng' => -9.1468],
            ['name' => 'KapitalStark Porto', 'address' => 'Rua de Santa Catarina, 200, 2.º andar', 'city' => 'Porto', 'zip' => '4000-447', 'phone' => '+351220001234', 'lat' => 41.1496, 'lng' => -8.6109],
        ];
        return view('pages.agencies', compact('agencies'));
    }
    public function glossary() { return view('pages.glossary'); }
    public function legal()    { return view('pages.legal'); }
    public function terms()    { return view('pages.terms'); }
    public function privacy()  { return view('pages.privacy'); }
    public function contact()  { return view('pages.contact'); }
    public function appointment() { return view('pages.appointment'); }

    public function testimonials()
    {
        $testimonials = require app_path('Data/testimonials.php');
        $loanTypes = [
            'immobilier' => 'Prêt Immobilier',
            'automobile'  => 'Prêt Automobile',
            'personnel'   => 'Prêt Personnel',
            'entreprise'  => 'Prêt Entreprise',
            'agricole'    => 'Prêt Agricole',
            'microcredit' => 'Microcrédit',
        ];
        return view('pages.testimonials', compact('testimonials', 'loanTypes'));
    }

    public function guides()  { return view('pages.guides'); }
    public function values()  { return view('pages.values'); }
    public function press()   { return view('pages.press'); }
    public function cookies() { return view('pages.cookies'); }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        ContactRequest::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip'      => $request->ip(),
        ]);

        Mail::to($request->email)->queue(new ContactConfirmation(
            senderName:     $request->name,
            senderEmail:    $request->email,
            contactSubject: $request->subject,
            messageBody:    $request->message,
        ));

        return back()->with('success', __('pages.contact.success'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'phone'        => 'required|string|max:30',
            'email'        => 'required|email|max:150',
            'project_type' => 'required|string|max:50',
            'date'         => 'required|date|after:today',
            'time'         => 'required|string|max:10',
            'notes'        => 'nullable|string|max:1000',
        ]);

        AppointmentRequest::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'project_type' => $request->project_type,
            'date'         => $request->date,
            'time'         => $request->time,
            'notes'        => $request->notes,
            'ip'           => $request->ip(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok']);
        }

        return back()->with('rdv_success', true);
    }

    public function storeNewsletter(Request $request)
    {
        $request->validate(['email' => 'required|email|max:150']);

        $source = $request->input('source', 'home');

        NewsletterSubscription::firstOrCreate(
            ['email' => $request->email],
            ['source' => $source, 'active' => true]
        );

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok']);
        }

        return back()->with('newsletter_success', true);
    }
}
