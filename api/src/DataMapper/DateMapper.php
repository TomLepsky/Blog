<?php

namespace App\DataMapper;

use DateTimeInterface;

class DateMapper
{
    public static function mapArticlePublishDate(DateTimeInterface $date) : string
    {
        $diff = time() - $date->getTimestamp();
        switch (true) {
            case $diff < 0:
                return "Hello from future! #_#";

            case $diff < 60:
                return "{$diff}s ago";

            case $diff < 3600:
                $min = floor($diff / 60);
                return "{$min}m ago";

            case $diff < 86400:
                $hours = floor($diff / 3600);
                return "{$hours}h ago";

            default:
                return $date->format(DateTimeInterface::W3C);
        }

    }
}
