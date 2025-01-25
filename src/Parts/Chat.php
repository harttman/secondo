<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo\Parts;

use Secondo\Utils\BaseApi;

class Chat {
    public ?int $id;
    public string $type;
    public ?string $title;
    public ?string $username;
    public ?string $first_name;
    public ?string $last_name;
    public ?bool $is_forum;
    private BaseApi $api;

    /**
     * Chat construcor.
     * 
     * @param object $data Chat data object from API
     * @param BaseApi $api instance of baseAPI for API communication
     */
    public function __construct(mixed $data, BaseApi $api) {
        $this->api = $api;
        
        $this->id = $data->id ?? null;
        $this->title = $data->title ?? null;
        $this->username = $data->username ?? null;
        $this->first_name = $data->first_name ?? null;
        $this->last_name = $data->last_name ?? null;
        $this->is_forum = $data->is_forum ?? false;
    }

    /**
     * Sends a message to the chat.
     * 
     * @param string $text The message text to send.
     * @param array $options Additional options for the message (e.g., parse_mode, disable_notification).
     * .
     */
    public function send(string $text, array $options = []) {
        if(empty($this->id)) $this->api->logger->critical("CANNOT GET ID!");
        $data = array_merge([
            "chat_id" => $this->id,
            "text" => $text
        ], $options);

       try {
          return $this->api->sendPost(
            "sendMessage",
            $data
          );
       } catch(\Exception $e) {}
    }
    
    public function leaveChat(string|int $chat_id = null) {
        if($chat_id === null) $chat_id = $this->id;
        $data = [
            "chat_id" => $chat_id 
        ];
        return $this->api->sendPost(
            "leaveChat",
            $data
        );
    }

    public function getChatMemberCount(string|int $chat_id = null) {
        if($chat_id === null) $chat_id = $this->id;
        $data = [
            "chat_id" => $chat_id,
        ];
        return $this->api->sendPost("getChatMemberCount", $data);
    }
}