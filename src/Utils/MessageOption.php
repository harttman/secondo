<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */
namespace Secondo\Utils;

enum MessageOption: string {
    case HTML = "HTML";
    case MARKDOWN = "MARKDOWN";
    case DISABLE_NOTIFICATION  = "disable_notification";
}