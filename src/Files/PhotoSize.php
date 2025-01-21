<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo\Files;

use Secondo\Utils\BaseApi;

class PhotoSize {
    public string $file_id;
    public ?string $file_unique_id;
    public ?int $width;
    public ?int $height;
    public ?int $file_size;

    private BaseApi $api;

    public function __construct(mixed $data, BaseApi $api) {
        $this->api = $api;

        $this->file_id = $data->file_id;
        $this->file_unique_id = $data->file_unique_id ?? null;
        $this->width = $data->width ?? null;
        $this->height = $data->height ?? null;
        $this->file_size = $data->file_size  ?? null;
    }
}