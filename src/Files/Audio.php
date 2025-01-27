<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */

namespace Secondo\Files;

use Secondo\Utils\BaseApi;
use Secondo\Files\PhotoSize;

class Audio {
    public ?string $file_id;
    public ?string $file_unique_id;
    public ?int $duration;
    public ?string $performer;
    public ?string $title;
    public ?string $file_name;
    public ?string $mime_type;
    public ?PhotoSize $thumbnail;
    
    private BaseApi $api;
    public function __construct(mixed $data, BaseApi $api) {
        $this->api = $api;

        $this->file_id = $data->file_id ?? null;
        $this->file_unique_id = $data->file_unique_id ?? null;
        $this->duration = $data->duration ?? null;
        $this->performer = $data->performer ?? null;
        $this->title = $data->title ?? null;
        $this->file_name = $data->file_id ?? null;
        $this->mime_type = $data->mime_type ?? null;
        $this->thumbnail = $data->thumbnail ?? null;
    }
}