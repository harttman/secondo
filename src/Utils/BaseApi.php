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
}