<?php

namespace App\Twig\Components;

use App\Service\ClientGoogleService;
use App\Service\YouTubeService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('AddVideo')]
class AddVideoComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';
    private YouTubeService $youTubeService;

    public function __construct(ClientGoogleService $clientGoogleService)
    {
        $this->youTubeService = new YouTubeService($clientGoogleService->getClient());
    }
    public function getYoutubeId(): string
    {
        if (!$this->query) {
            return '';
        }
        return $this->youTubeService->getVideoByUrl($this->query);
    }
    public function getYoutubeVideo(): array
    {
        if (!empty($this->query)) {
        $id = $this->getYoutubeId();
        $videoData = $this->youTubeService->getVideoById($id);
        } else {
            $videoData = [];
        }
        return $videoData;
    }
}
