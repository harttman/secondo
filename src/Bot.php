<?php
namespace Secondo;

use Secondo\Parts\Message;

class Bot {
    public string $token;
    private string $urlApi = "https://api.telegram.org/bot$token";
    private int $offset;
    public Message | null $message;
    public function __construct(string $token) {
        $this->token = $token;
        $this->offset = 0;
        $this->message = null;
    }

    public function poll(): never {
        while(true) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$this->urlApi/getUpdates?offset=".$this->offset);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resonse = json_decode(curl_exec($ch));
            foreach($resonse as $update) {
                $update_id = $update->update_id;
                $this->message = new Message($update->message);
                $this->offset = $update_id + 1;
            }
        }
    }
}