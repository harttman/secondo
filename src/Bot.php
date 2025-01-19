<?php
namespace Secondo;

use Secondo\Parts\Message;

use Secondo\Utils\BaseApi;

class Bot {
    public string $token;
    private BaseApi $api;
    private int $offset;
    public Message | null $message;
    private array $eventHandler = [];

    public function __construct(string $token) {
        $this->token = $token;
        $this->offset = 0;
        $this->message = null;
        $this->api = new BaseApi($token);
    }

    /**
     * Listener all events (etc. message).
     * @param string $event event for work.
     * @param callable $callback callback function
     * @return void
     */
    public function on(string $event, callable $callback) {
        if(!isset($this->eventHandler[$event])) {
            $this->eventHandler[$event] = [];
        }
        $this->eventHandler[$event][] = $callback;
    }

    /**
     * Triggers specify event
     * @param string $event evet name.
     * @param mixed $data   params.
     * @return void
     */
    public function triggers(string $event, mixed $data) {
        if(isset($this->eventHandler[$event])) {
            foreach($this->eventHandler[$event] as $hadler) {
                $hadler($data);
            }
        }
    }

    /**
     * Connect your bot.
     * @return never
     */

    public function poll(): never {
       while(true) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->api->getUpdates()}?offset={$this->offset}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $response = json_decode($result);
        curl_close($ch);

        if(isset($response->result)) {
            foreach($response->result as $update) {
                $this->offset = $update->update_id + 1;
                if(isset($update->message)) {
                    $this->message = new Message($update->message, $this->token);
                    $this->triggers('message', $this->message);
                }
            }
        }
        sleep(1);
       }
    }
}