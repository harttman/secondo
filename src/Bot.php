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

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->api = new ClientApi($params["token"]);
    }

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

    public function poll(): void
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
