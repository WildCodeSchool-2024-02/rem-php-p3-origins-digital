<?php

namespace App\Service;

use Google\Service\YouTube\SearchListResponse;
use Google_Client;
use Google_Service_YouTube;

class YouTubeService
{
    private Google_Service_YouTube $youTube;
    public function __construct(Google_client $client)
    {
        $this->youTube = new Google_Service_YouTube($client);
    }
    public function getVideoByUrl(string $url): string
    {
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $query);
        $videoId = $query['v'];
        return $videoId;
    }
    public function getVideoById(string $id): array
    {
        $queryParams = [
            'id' => $id
        ];
        $response = $this->youTube->videos->listVideos('id,snippet', $queryParams);
        $videoData = [];
        foreach ($response as $video) {
            $videoData = [
                'videoId' => $video['id'],
                'title' => $video['snippet']['title'],
                'thumbnail' => $video['snippet']['thumbnails']['high']['url'],
                'description' => $video['snippet']['description'],
                'channel' => $video['snippet']['channelId'],
                'channelTitle' => $video['snippet']['channelTitle'],
                'publishedTime' => $video['snippet']['publishedTime'],
                'videoFrom' => 'youtube'
            ];
        }

        return $videoData;
    }
    public function getListVideosByChannelId(string $channelId, int $mawResults): array
    {
        $queryParams = [
            'channelId' => $channelId,
            'maxResults' => $mawResults,
            'order' => 'date',
            'type' => 'video',
            'videoEmbeddable' => 'true',
            //'videoDuration' => 'medium'
        ];
        $response = $this->youTube->search->listSearch('id,snippet', $queryParams);

        return $this->responseToArray($response);
    }
    private function responseToArray($response): array
    {
        $videoData = [];
        foreach ($response as $video) {
            $videoData[] = [
                'videoId' => $video['id']['videoId'],
                'title' => $video['snippet']['title'],
                'thumbnail' => $video['snippet']['thumbnails']['high']['url'],
                'description' => $video['snippet']['description'],
                'channel' => $video['snippet']['channelId'],
                'channelTitle' => $video['snippet']['channelTitle'],
                'publishedTime' => $video['snippet']['publishedTime'],
                'videoFrom' => 'youtube'
            ];
        }
        return $videoData;
    }
}
