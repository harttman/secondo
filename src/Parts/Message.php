<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo\Parts;

use Secondo\Files\Audio;
use Secondo\Game\Dice;
use Secondo\Utils\BaseApi;
use Secondo\Parts\Chat;
use Secondo\Parts\Member\User;

class Message {
    public int $message_id;
    public ?User $from;
    public ?int $sender_boost_count;
    public ?int $date;

    public Audio $audio;

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
        print_r($data);
        $this->audio = new Audio($data->audio, $api);
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

    /**
     * Send photo a specify chat.
     * @param int $chat_id Chat id
     * @param string $string path to file.
     * @param
     */
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
     * @return array Returns an associative array of 'emoji' => dice and 'value' => (🎲 1..6). Or [] if failed.
    */
    public function sendDice(int $chat_id, string $emoji): array {
        $data = [
            "chat_id" => $chat_id,
            "emoji" => $emoji
        ];

        $r = $this->api->sendPost("sendDice", $data);

        if(isset($r->ok) && $r->ok == 1) {
            $this->api->logger->info("Dice sent to $chat_id with emoji {$r->result->dice->emoji} and value {$r->result->dice->value}");
            
            return [
                "emoji" => $r->result->dice->emoji,
                "value" => $r->result->dice->value
            ];
        } else {
            $this->api->logger->alert("Failed to send dice to $chat_id.");
            return [];
        }
    }
}
