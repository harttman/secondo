<?php
/**
 *  @author harttman https://github.com/harttman
 * code writen by harttman
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

    /**
     * Get url for send message.
     * @return string
     */
    public function sendMessage(): string {
        return "{$this->apiUrl}/sendMessage";
    }

    /**
     * Get url for getUpdate.
     * @return string
     */
    public function getUpdates(): string {
        return "{$this->apiUrl}/getUpdates";
    }
}