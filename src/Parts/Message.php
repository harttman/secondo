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

    public function sendLocation(int|string $chat_id, bool $latitude,bool $longitude, array $options = []) {
        $data = [
            "chat_id" => $chat_id,
            "latitude" => $latitude,
            "longitude" => $longitude,
        ];

        $this->api->sendPost("sendLocation", array_merge($data, $options));
    }

    public function sendPhoto(int $chat_id, string $photo, string $caption = null) {
        $data = [
            "chat_id" => $chat_id,
            "photo" => new \CurlFile($photo),
            "caption" => $caption ?? null
        ];

        return $this->api->sendMediaPost("sendPhoto", $data);
    }

    /** 
     * Send dice a specify chat.
     * @param int $chat_id Chat id.
     * @param string $emoji Emoji on which the dice throw animation is based. Currently, must be one of “🎲”, “🎯”, “🏀”, “⚽”, “🎳”, or “🎰”. Dice can have values 1-6 for “🎲”, “🎯” and “🎳”, values 1-5 for “🏀” and “⚽”, and values 1-64 for “🎰”. Defaults to “🎲”`
     * 
     * @return mixed
    */
    public function sendDice(int $chat_id, string $emoji) {
        $data = [
            "chat_id" => $chat_id,
            "emoji" => $emoji
        ];

        return $this->api->sendPost("sendDice", $data);
    }
}
