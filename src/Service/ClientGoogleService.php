<?php

namespace App\Service;

use Google_Client;
use Symfony\Component\HttpFoundation\RequestStack;

class ClientGoogleService extends \Google_Client
{
    private Google_Client $client;
    public function __construct(
        string $projectDir,
        private RequestStack $requestStack,
    ) {
        $this-> client = new Google_Client();
        $this-> client-> setApplicationName("PausePlayGame");
        $this->client->setScopes(['https://www.googleapis.com/auth/youtube.readonly']);
        $this->client->setAuthConfig($projectDir . '/config/client_secret.json');
        $this->client->setAccessType('offline');
        $this->initializeAccessToken();
    }
    private function initializeAccessToken(): void
    {
        $session = $this->requestStack->getSession();
        $accessToken = $session->get('access_token');
        if (!empty($accessToken)) {
            $this->client->setAccessToken($accessToken);
        }
        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            }
        }
        $session->set('access_token', $this->client->getAccessToken());
    }
    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }
    public function fetchAccessTokenWithAuthCodes(string $code): void
    {
        $session = $this->requestStack->getSession();
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
        $this->client->setAccessToken($accessToken);
        $session->set('access_token', $this->client->getAccessToken());
    }
    public function getClient(): Google_Client
    {
        return $this->client;
    }
}
