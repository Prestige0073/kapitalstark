<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushService
{
    private WebPush $push;

    public function __construct()
    {
        $this->push = new WebPush([
            'VAPID' => [
                'subject'    => config('app.vapid_subject', 'mailto:contact@kapitalstark.fr'),
                'publicKey'  => config('app.vapid_public_key'),
                'privateKey' => config('app.vapid_private_key'),
            ],
        ]);
    }

    /**
     * Envoie une notification push à tous les abonnements d'un user.
     */
    public function sendToUser(User $user, string $title, string $body, string $url = '/'): void
    {
        $subs = PushSubscription::where('user_id', $user->id)->get();
        if ($subs->isEmpty()) return;

        $payload = json_encode([
            'title' => $title,
            'body'  => $body,
            'url'   => $url,
            'icon'  => '/favicon.ico',
        ]);

        foreach ($subs as $sub) {
            $this->push->queueNotification(
                Subscription::create([
                    'endpoint'        => $sub->endpoint,
                    'keys'            => [
                        'p256dh' => $sub->p256dh,
                        'auth'   => $sub->auth,
                    ],
                ]),
                $payload
            );
        }

        foreach ($this->push->flush() as $report) {
            if ($report->isSubscriptionExpired()) {
                PushSubscription::where('endpoint', $report->getRequest()->getUri()->__toString())->delete();
            }
        }
    }
}
