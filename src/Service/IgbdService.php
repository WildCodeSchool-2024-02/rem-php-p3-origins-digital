<?php

namespace App\Service;

use App\Repository\ParamApiRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IgbdService
{
    private HttpClientInterface $httpClient;
    private string $twitch_client_id;
    private ParamApiRepository $paramApiRepository;

    public function __construct(
        HttpClientInterface $httpClient,
        ParamApiRepository $paramApiRepository,
        string $twitch_client_id
    ) {
        $this->httpClient = $httpClient;
        $this->paramApiRepository = $paramApiRepository;
        $this->twitch_client_id = $twitch_client_id;
    }
    public function getGameExist(string $nameGame): array
    {
        $nameGame = mb_strtolower($nameGame);
        $nameGame = ucwords($nameGame);
        $response = $this-> httpClient ->request('POST', 'https://api.igdb.com/v4/games', [
            'headers' => [
                'Client-ID' => $this ->twitch_client_id,
                'Authorization' => $this->paramApiRepository->findOneBy(['apiName' => 'twitch'])->getToken(),
            ],
            'query' => [
                'search' => $nameGame,
                'fields' => 'name'
            ]
        ]);
        $games = $response->toArray();
        $game = array_filter($games, function ($game) use ($nameGame) {
            return $game['name'] === $nameGame;
        });
        return array_values($game)[0];
    }
    public function getGameInfo(int $gameId): array
    {
        $response = $this-> httpClient ->request('POST', 'https://api.igdb.com/v4/games', [
            'headers' => [
                'Client-ID' => $this ->twitch_client_id,
                'Authorization' => $this->paramApiRepository->findOneBy(['apiName' => 'twitch'])->getToken(),
            ],
            'body' => "fields name, summary, cover; where id = $gameId;"
        ]);
        $gameInfo = $response->toArray();
        return array_values($gameInfo)[0];
    }
    public function getCover(int $coverId): string
    {
        $response = $this-> httpClient ->request('POST', 'https://api.igdb.com/v4/covers', [
            'headers' => [
                'Client-ID' => $this ->twitch_client_id,
                'Authorization' => $this->paramApiRepository->findOneBy(['apiName' => 'twitch'])->getToken(),
            ],
            'body' => "fields url; where id = $coverId;"
        ]);
        $data = $response->toArray();
        $data = array_filter($data)[0];
        $cover = $data['url'];
        $cover = str_replace('t_thumb', 't_720p', $cover);
        return $cover;
    }
}
