<?php

namespace App\Service;

use App\Entity\ParamApi;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TwitchTokenService
{
    private HttpClientInterface $twitch;
    private string $twitch_client_id;
    private string $twitch_client_secret;
    private EntityManagerInterface $manager;
    private ?ParamApi $twitchName;
    public function __construct(
        HttpClientInterface $twitch, 
        string $twitch_client_id, 
        string $twitch_client_secret, 
        EntityManagerInterface $manager
    ) {
        $this->twitch = $twitch;
        $this->twitch_client_id = $twitch_client_id;
        $this->twitch_client_secret = $twitch_client_secret;
        $this->manager = $manager;
        $this->findByApiName();
    }
    private function findByApiName(): void
    {
        $paramApiRepository = $this->manager->getRepository(ParamApi::class);
        $this->twitchName = $paramApiRepository->findOneBy(['apiName' => 'twitch']);
    }
    public function verificationTwitchToken(): bool
    {
        if ($this->twitchName === null) {
            return false;
        }
        if ($this->twitchName->getDateToken() < date('Y-m-d')) {
            return false;
        }
        return true;
    }
    public function updateTwitchToken(): void
    {
        $paramApi = new ParamApi();
        if ($this->twitchName === null) {
            $paramApi->setApiName('twitch');
        }
        $newToken = $this->getNewToken();
        $paramApi->setDateToken(DateTime::createFromFormat('Y-m-d', $newToken['expires_in']));
        $paramApi->setToken('Bearer ' . $newToken['token']);
        if ($this->twitchName === null) {
            $this->manager->persist($paramApi);
        }
        $this->manager->flush();
    }
    private function getNewToken(): array
    {
        $response = $this->twitch->request('POST', 'https://id.twitch.tv/oauth2/token', [
            'query' => [
                'client_id' => $this->twitch_client_id,
                'client_secret' => $this->twitch_client_secret,
                'grant_type' => 'client_credentials',
            ],
        ]);
        $data = $response->toArray();
        $date = $this->timeToDateConverter($data['expires_in']);
        $token = ['token' => $data['access_token'], 'expires_in' => $date, 'token_type' => $data['token_type']];
        return $token;
    }
    private function timeToDateConverter(int $time): string
    {
        $currentTime = time();
        $expirationTime  = $currentTime + $time;
        $expirationDate = date('Y-m-d', $expirationTime);
        return $expirationDate;
    }
}

