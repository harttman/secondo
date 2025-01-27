<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo;

use Secondo\Parts\Message;

use Secondo\Utils\BaseApi;

class Bot {
    private BaseApi $api;
    private int $offset;
    private bool $running;
    public ?Message $message;
    private array $eventHandler = [];

    /**
     * Create client.
     * @param string $token
     */
    public function __construct(string $token) {
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
     * Start long polling!
     */
    public function poll() {
        $this->running = true;
        static $lastLogTime = 0;
    
        while ($this->running) {
            if (time() - $lastLogTime > 60) {
                $this->api->logger->info("Send request to connect");
                $lastLogTime = time();
            }
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "{$this->api->getUpdatesUrl()}?offset={$this->offset}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    
            $result = curl_exec($ch);
    
            if (curl_errno($ch)) {
                $this->api->logger->critical("API error: " . curl_error($ch));
                curl_close($ch);
                sleep(1);
                continue;
            }
    
            $response = json_decode($result);
            curl_close($ch);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->api->logger->critical("JSON decode error: " . json_last_error_msg());
                sleep(1);
                continue;
            }
            if ($response->ok === false) {
                $this->api->logger->critical("Failed to connect to API", [
                    "Ok" => $response->ok
                ]);
            }


            if (isset($response->result)) {
                foreach ($response->result as $update) {
                    $this->offset = $update->update_id + 1;
                    if (isset($update->message)) {
                        $this->message = new Message($update->message, $this->api);
                        $this->triggers('message', $this->message);
                    }
                }
            }
            sleep(1);
        }
    }
    
}