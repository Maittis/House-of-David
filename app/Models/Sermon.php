<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video_url',
    ];

    /**
     * Accessor to get the YouTube video ID from the video_url.
     *
     * @return string|null
     */
    public function getYoutubeIdAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        // Parse the URL to get the query string
        $urlParts = parse_url($this->video_url);

        if (!isset($urlParts['query'])) {
            return null;
        }

        parse_str($urlParts['query'], $queryParams);

        return $queryParams['v'] ?? null;
    }
}
