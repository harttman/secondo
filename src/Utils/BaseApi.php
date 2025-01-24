<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo\Utils;

class BaseApi {
    private string $apiUrl;
    /**
     * Create BaseApi settings
     * @param string $token
     */
    public function __construct(string $token) {
        $this->apiUrl = "https://api.telegram.org/bot{$token}";
    }

    /**
     * Get api url address.
     * @return string
     */
    public function getUrl(): string {
        return $this->apiUrl;
    }

    public function getUpdatesUrl(): string {
        return "{$this->apiUrl}/getUpdates";
    }

   public function sendPost(string $post, mixed $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->apiUrl}/$post");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($ch);
        curl_close($ch);
        return json_decode($r);
   }

   public function sendMediaPost(string $post, array $data) {
        $ch = curl_init("{$this->getUrl()}/$post");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: multipart/form-data",
            ],
            CURLOPT_POSTFIELDS => $data,
            ]);
        
        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            throw new \Exception("GET ERROR IN POST => ". curl_error($ch));
        }

        curl_close($ch);
        return json_decode($response);
   }

   public function logError(string $message) {
      return throw new \Exception($message);
   }
}