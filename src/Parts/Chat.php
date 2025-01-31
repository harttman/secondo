<?php

namespace Secondo\Parts;

use Secondo\Api\ClientApi;

class Chat
{
    public int $id;
    public string $type;
    public bool $is_forum;
    public string $title;
    public string $username;
    public string $first_name;
    public string $last_name;

    public ClientApi $api;
    public function __construct(mixed $data, ClientApi $api)
    {
        $this->id = $data->id ?? 0;
        $this->type = $data->type ?? "";
        $this->is_forum = $data->is_forum ?? false;
        $this->title = $data->title ?? "";
        $this->username = $data->username ?? "";
        $this->first_name = $data->first_name ?? "";
        $this->last_name = $data->last_name ?? "";

        $this->api = $api;
    }

    /**
     * Sends a message to the chat where the trigger was called.
     * @param string $content Message to be conveyed.
     * @param array $params Parameters as an associative array.
     * @return string
     */
    public function send(string $content, array $params = []) {
        $options = array_merge(
            [
                "chat_id" => $this->id,
                "text" => $content
            ],
            $params
        );
        return $this->api->sendPost("sendMessage", $options);
    }
}
