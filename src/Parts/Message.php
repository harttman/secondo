<?php
namespace Secondo\Parts;

use Secondo\Api\ClientApi;

class Message
{
    public int $message_id;
    public bool $is_bot;
    public string $first_name;
    public string $username;
    public string $language_code;
    public string $text;
    public int $chat_id;
    private ClientApi $api;
    public function __construct(mixed $data, ClientApi $api)
    {
        $this->api = $api;
        $this->message_id = $data->message_id;
        $this->is_bot = $data->from->is_bot ?? false;
        $this->first_name = $data->from->first_name ?? "";
        $this->username = $data->from->username ?? "";
        $this->language_code = $data->from->language_code ?? "";
        $this->text = $data->text ?? "";
        $this->chat_id = $data->chat->id;
    }

    public function sendMessage(int $chat_id, string $content): string
    {
        return $this->api->sendPost("sendMessage", [
            "chat_id" => $chat_id,
            "text" => $content,
        ]);
    }
}
