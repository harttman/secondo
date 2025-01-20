<?php
/**
 * @author harttman https://github.com/harttman
 */

namespace Secondo\Parts;

use Secondo\Utils\BaseApi;

class Chat {
    public ?int $id;
    private BaseApi $api;
    public function __construct(mixed $data, BaseApi $api) {
        $this->api = $api;
        $this->id = $data->id;
    }

    /**
     * Send to trigers chat.
     * @param string $text Message text.
     * @return void
     */
    public function send(string $text) {
        $data = [
            "chat_id" => $this->id,
            "text" => $text
        ];

        $this->api->sendPost("sendMessage", $data);
    }
}