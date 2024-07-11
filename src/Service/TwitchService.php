<?php

namespace App\Service;

use App\Repository\ParamApiRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

 /**
  * @SuppressWarnings(PHPMD)
  **/
class TwitchService
{
    private HttpClientInterface $httpClient;
    private string $twitch_client_id;
    private ParamApiRepository $paramApiRepository;
    public function __construct(
        HttpClientInterface $httpClient,
        string $twitch_client_id,
        ParamApiRepository $paramApiRepository
    ) {
        $this->httpClient = $httpClient;
        $this->twitch_client_id = $twitch_client_id;
        $this->paramApiRepository = $paramApiRepository;
    }
    public function getVideoByUrl(string $url): string
    {
        $urlParts = parse_url($url);
        $partPath = explode('/', $urlParts['path']);
        $videoId = end($partPath);
        return $videoId;
    }
    public function getVideoById(string $videoId): array
    {
        $response = $this->httpClient->request('GET', 'https://api.twitch.tv/helix/videos', [
            'headers' => [
                'Client-ID' => $this->twitch_client_id,
                'Authorization' => $this->paramApiRepository->findOneBy(['apiName' => 'twitch'])->getToken(),
            ],
            'query' => [
                'id' => $videoId,
            ],
        ]);

        $data = $response->toArray();
        $videoData = [
            'videoId' => $data['data']['0']['id'],
            'title' => $data['data']['0']['title'],
            'description' => $data['data']['0']['description'],
            'thumbnail' => $this->replacementThumbnailUrl($data['data']['0']['thumbnail_url']),
            'channel' => $data['data']['0']['user_id'],
            'channelTitle' => $data['data']['0']['user_name'],
            'published' => $data['data']['0']['published_at'],
            'videoFrom' => 'twitch'
        ];
        return $videoData;
    }
    public function replacementThumbnailUrl(string $thumbnail): string
    {
        $replacements = [
            '{width}' => 640,
            '{height}' => 320,
        ];
        $newThumbnail = str_replace(array_keys($replacements), array_values($replacements), $thumbnail);
        return $newThumbnail;
    }
    public function twitchUserExists(string $twitchUserName): bool
    {
        $response = $this->httpClient->request('GET', 'https://api.twitch.tv/helix/users', [
            'headers' => [
                'Client-ID' => $this->twitch_client_id,
                'Authorization' => $this->paramApiRepository->findOneBy(['apiName' => 'twitch'])->getToken(),
            ],
            'query' => [
                'login' => $twitchUserName,
            ]
        ]);
        $responseContent = $response ->toArray();
        if (empty($responseContent['data'])) {
            return false;
        } else {
            return true;
        }
    }
    public function getStreams(array $twitchUserNames): array
    {
        $twitchUserNames = implode("&user_login=", $twitchUserNames);
        $response = $this->httpClient->request(
            'GET',
            'https://api.twitch.tv/helix/streams?user_login=' . $twitchUserNames,
            [
            'headers' => [
                'Client-ID' => $this->twitch_client_id,
                'Authorization' => $this->paramApiRepository->findOneBy(['apiName' => 'twitch'])->getToken(),
            ],
            ]
        );
        $data = $response->toArray();
        return $data['data'];
    }
}
