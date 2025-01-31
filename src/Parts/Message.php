<?php
namespace Secondo\Parts;

use Secondo\Api\ClientApi;
use Secondo\Constants\Dice as C_Dice;
use Secondo\Parts\Game\Dice;
use Secondo\Parts\Member\From;

class Message
{
    public int $message_id;
    public bool $is_bot;
    public string $first_name;
    public string $username;
    public string $language_code;
    public string $text;
    public Chat $chat;
    public From $from;
    private ?ClientApi $api;
    public function __construct(mixed $data, ClientApi|null $api)
    {
        $this->api = $api;
        $this->message_id = $data->message_id;
        $this->is_bot = $data->from->is_bot ?? false;
        $this->first_name = $data->from->first_name ?? "";
        $this->username = $data->from->username ?? "";
        $this->language_code = $data->from->language_code ?? "";
        $this->text = $data->text ?? "";
        
        $this->from = new From($data->from);
        $this->chat = new Chat($data->chat, $api) ?? null;
    }

    /**
     * Sends a message to a specific chat.
     * @param int $chat_id The chat ID to which the string context will be sent.
     * @param string $content The content of the message can be anything but an empty line!
     * @return void
     */
    public function sendMessage(int $chat_id, string $content): void
    {
        $this->api->logger->logger->notice("I try send message!", 
        [
            "error_code" => "0"
        ]
        );

        $r = json_decode($this->api->sendPost("sendMessage", [
            "chat_id" => $chat_id,
            "text" => $content,
        ]));

        if($r->ok) $this->api->logger->logger->info("I successfuly send message!", ["error_code" => "0"]);

    }

    /**
     * Sends a dice to the chat with the specified ID, returning Class Dice
     * @param int $chat_id Chat ID where the dice will be sent
     * @param C_Dice|string $dice The dice itself is a regular emoji, use an Enumeration (recommended) or a string with an emoji
     * @return Dice The class returns two properties, the dice value and the emoji
     */
    public function sendDice(int $chat_id, C_Dice|string $dice = C_DICE::DICE): Dice
    {
        $this->api->logger->logger->notice("I try send message!", [
            "eror_code" => "1"
        ]);

        $r = json_decode(
            $this->api->sendPost("sendDice", [
                "chat_id" => $chat_id,
                "emoji" => $dice,
            ])
        );
        if($r->ok) $this->api->logger->logger->info("Dice send success!", [
            "error_code" => "0",
            "value" => $r->result->dice->value
        ]);

        return new Dice($r->result->dice);
    }
}
