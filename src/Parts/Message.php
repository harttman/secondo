<?php
/**
 * @author harttman https://github.com/harttman
 */

namespace Secondo\Parts;

use Secondo\Utils\BaseApi;
use Secondo\Parts\Chat;

class Message {
    public ?string $text;
    public ?int $id;
    public ?bool $is_bot;
    public ?string $language_code;
    public ?Chat $chat;
    private BaseApi $api;
    
    public function __construct(mixed $data, BaseApi $api) {
        $this->text = $data->text ?? null;
        $this->id = $data->id ?? null;
        $this->is_bot = $data->is_bot ?? null;
        $this->language_code = $data->language_code ?? null;
        $this->chat = new Chat($data->chat, $api);
    }

    /**
     * 
     */
    public function send(int $id, string $text) {
        $data = [
            "chat_id" => $id,
            "text" => $text
        ];

        $this->api->sendPost("sendMessage", $data);
    }
}