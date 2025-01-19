<?php
namespace Secondo\Parts;
use Secondo\Utils\BaseApi;
class Message {
    public string|null $text;
    public bool|null $is_bot;
    public string|null $language_code;
    public int|null $id;
    public int|null $chat_id;
    private BaseApi $api;
    public function __construct($data, $token) {
        $this->text = $data->text ?? null;
        $this->isBot = $data->from->is_bot ?? null;
        $this->language_code = $data->from->language_code ?? null;
        $this->id = $data->message_id ?? null;
        $this->chat_id = $data->chat->id ?? null;
        $this->api = new BaseApi($token);
    }

    /**
     * sends a message to a specific chat.
     * @param int $id Numeric ID of the chat.
     * @param string $content content message.
     * * @return void
     */
    public function send(int $id, string $content) {
        $url = $this->api->sendMessage();
        $data = [
            "chat_id" => $id,
            "text" => $content
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch); 
    }
}