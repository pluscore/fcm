<?php

namespace Plus\Fcm;

use Illuminate\Notifications\Notification;

class FcmChannel
{
    /**
     * @var MessagingClient
     */
    private $client;

    /**
     * Construct FcmChannel.
     *
     * @param MessagingClient $client
     */
    public function __construct(MessagingClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification through the fcm.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toFcm($notifiable);
        $target = $notifiable->routeNotificationForFcm();

        $target->chunk(1000)->each(function ($ids) use ($data) {
            $data['registration_ids'] = $ids->toArray();
            $this->client->send($data);
        });
    }
}
