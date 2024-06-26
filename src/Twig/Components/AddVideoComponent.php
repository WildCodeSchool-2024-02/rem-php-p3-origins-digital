<?php

namespace App\Twig\Components;

use App\Entity\Video;
use App\Form\VideoType;
use App\Service\ClientGoogleService;
use App\Service\TwitchService;
use App\Service\YouTubeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('AddVideo')]
class AddVideoComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true)]
    public string $query = '';
    #[LiveProp]
    public ?Video $initialFormData = null;
    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(VideoType::class, $this->initialFormData);
    }
    private YouTubeService $youTubeService;
    private TwitchService $twitchService;

    public function __construct(
        ClientGoogleService $clientGoogleService,
        TwitchService $twitchService,
    ) {
        $this->youTubeService = new YouTubeService($clientGoogleService->getClient());
        $this->twitchService = $twitchService;
    }
    public function getRoutingUrl(): string
    {
        if (!$this->query) {
            return '';
        }
        $url = trim($this->query, ' ');
        if (str_contains(parse_url($url, PHP_URL_HOST), 'youtube')) {
            return $this->youTubeService->getVideoByUrl($this->query);
        } elseif ((str_contains(parse_url($url, PHP_URL_HOST), 'twitch'))) {
            return $this->twitchService->getVideoByUrl($this->query);
        } else {
            return "URL not valid";
        }
    }
    public function getYoutubeVideo(): array
    {
        $url = trim($this->query, ' ');
        if (!empty($this->query) && str_contains(parse_url($url, PHP_URL_HOST), 'youtube')) {
            $id = $this->getRoutingUrl();
            $videoData = $this->youTubeService->getVideoById($id);
        } else {
            $videoData = [];
        }
        return $videoData;
    }
    public function getTwitchVideo(): array
    {
        $url = trim($this->query, ' ');
        if (!empty($this->query) && (str_contains(parse_url($url, PHP_URL_HOST), 'twitch'))) {
            $id = $this->getRoutingUrl();
            $videoData = $this->twitchService->getVideoById($id);
        } else {
            $videoData = [];
        }
        return $videoData;
    }
}