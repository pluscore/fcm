<?php

namespace Plus\Fcm;

use Zttp\Zttp;

class MessagingClient
{
    /**
     * @var string
     */
    private $authKey;

    /**
     * Construct MessagingClient.
     *
     * @param string $authKey
     */
    public function __construct($authKey)
    {
        $this->authKey = $authKey;
    }

    /**
     * Send a message through firebase.
     *
     * @param array $data
     *
     * @return array
     */
    public function send($data)
    {
        if (app()->environment() !== 'production') {
            return logger()->info('Sending fcm: ', compact('data'));
        }

        $response = Zttp::withHeaders($this->headers())
            ->post('https://fcm.googleapis.com/fcm/send', $data);

        logger()->info('Sent a message through fcm: ', [
            'data' => $data,
            'response' => $response->body(),
        ]);

        if ($response->isSuccess()) {
            return $response->json();
        }

        logger()->error('Fcm cloud messaging failed.', [
            'response_body' => $response->body(),
        ]);
    }

    /**
     * @return array
     */
    private function headers()
    {
        return [
            'Authorization' => 'key='.$this->authKey,
            'Content-Type' => 'application/json',
        ];
    }
}
