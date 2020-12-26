<?php

namespace App\Youtube;



use Illuminate\Support\Facades\Http;

class YoutubeService
{

    private $key;

    /**
     * YoutubeService constructor.
     * @param String $key
     */
    public function __construct(String $key)
    {
        $this->key = $key;
    }

    public function handleVideoDuration(string $url): int
    {
        // extract video id from url
        if(empty($url)) {
            return 0;
        }

        preg_match("/embed\/(.+)/",$url,$matches);

        $video_id = $matches[1];
        // get data from youtub by launch an url api
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?key=".$this->key."&id=".$video_id."&part=contentDetails");
        $data = json_decode($response);
        $duration = $data->items[0]->contentDetails->duration;
        $interval = new \DateInterval($duration);
        return ($interval->s + $interval->i * 60 + $interval->h*3600);
    }

}
