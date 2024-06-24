<?php

namespace App\Twig\Components;

use App\Entity\Video;
use App\Form\VideoType;
use App\Service\ClientGoogleService;
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
