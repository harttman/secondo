<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class BaseApi {
    public Logger $logger;
    private string $apiUrl;
    /**
     * Create BaseApi settings
     * @param string $token
     */
    public function __construct(string $token) {
        $this->apiUrl = "https://api.telegram.org/bot{$token}";
        $this->logger = new Logger("SECONDO: ");
        $this->logger->pushHandler(new StreamHandler(__DIR__."/../../secondo.log", Level::Warning));
        $consoleHandler = new StreamHandler('php://stdout', Level::Warning);
        $this->logger->pushHandler($consoleHandler);
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
        $this->logger->info("Send post $post..");
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "{$this->apiUrl}/$post");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $r = curl_exec($ch);
            curl_close($ch);
            return json_decode($r);
        } catch(\Exception $e) {
            $this->logger->critical("Send post [$post] is error!: {$e->getMessage()}");
        }
   }

   public function sendMediaPost(string $post, array $data) {
        $this->logger->info("Send media post [$post]");
        try {
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
            print_r($response);
            curl_close($ch);
            return json_decode($response);
        } catch(\Exception $e) {}
   }
}