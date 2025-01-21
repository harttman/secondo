<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo\Parts;

use Secondo\Utils\BaseApi;
use Secondo\Parts\Chat;
use Secondo\Parts\Member\User;

class Message {
    public int $message_id;
    public ?User $from;
    public ?int $sender_boost_count;
    public ?int $date;
    public Chat $chat;

    public ?string $text;

    private BaseApi $api;
    public function __construct(mixed $data, BaseApi $api) {
        $this->api = $api;

        $this->message_id = $data->message_id;
        //$this->message_thread_id = $data->message_thread_id ?? null;
        $this->from = new User($data->from, $api);
        $this->sender_boost_count = $data->sender_boost_count ?? null;
        $this->date = $data->data ?? null;
        $this->chat = new Chat($data->chat, $api);
        $this->text = $data->text ?? "";
    }

    /**
     * Send message a sprecify chat.
     * @param int $chat_id Chat id.
     * @param string $text Content message.
     * @return void
     */
    public function send(int $chat_id, string $text) {
        $data = [
            "chat_id" => $chat_id,
            "text" => $text
        ];

        $this->api->sendPost("sendMessage", $data);
    }

    public function sendPhoto(int $chat_id, string $photo, string $caption = null) {
        $data = [
            "chat_id" => $chat_id,
            "photo" => new \CurlFile($photo),
            "caption" => $caption ?? null
        ];

        return $this->api->sendMediaPost("sendPhoto", $data);
    }
}
