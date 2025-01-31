<?php
namespace Secondo;

use GuzzleHttp\Exception\GuzzleException;
use Secondo\Api\ClientApi;
use Secondo\Parts\Message;

class Bot
{
    public ClientApi $api;
    public array $params;
    private int $offset = 0;
    private array $eventHandler = [];
    public Message $message;

    /**
     * Creating your client and connecting it to the Telegram API.
     * @param array $params Takes an associative array with values, the main value being "token"
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->api = new ClientApi($params["token"]);
    }

    /**
     * Event handler, you can see the available events in the documentation!
     * @param string $event Events you want to process
     * @param callable $function An event callback function; in the body of the function you can configure the bot’s response to different triggers.
     * @return void
     */
    public function on(string $event, callable $function): void
    {
        if (!isset($this->eventHandler[$event])) {
            $this->eventHandler[$event] = [];
        }
        $this->eventHandler[$event][] = $function;
    }

    public function triggers(string $event, mixed $data): void
    {
        if (isset($this->eventHandler[$event])) {
            foreach ($this->eventHandler[$event] as $handler) {
                call_user_func($handler, $data);
            }
        }
    }

    /**
     * Trying to connect your client to the telegram api, does not accept an argument, starts a constant loop.
     * @return never
     */
    public function poll(): never
    {
        while (true) {
            try {
                $response = json_decode(
                    $this->api->sendGet("getUpdates", [
                        "offset" => $this->offset,
                    ])
                );

                foreach ($response->result as $update) {
                    $this->offset = $update->update_id + 1;
                    if (isset($update->message)) {
                        $this->message = new Message(
                            $update->message,
                            $this->api
                        );
                        $this->triggers("message", $this->message);
                    }
                }
            } catch (GuzzleException $e) {
            }
        }
    }
}
