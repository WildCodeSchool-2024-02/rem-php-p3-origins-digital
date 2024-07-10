<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $videoPicking = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlVideo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $channelId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $channelTitle = null;

    #[ORM\Column(length: 100)]
    private ?string $videoFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $publishedTime = null;

    #[ORM\ManyToOne(inversedBy: 'video')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;
    #[ORM\ManyToOne(inversedBy: 'videos')]
    private ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoPicking(): ?string
    {
        return $this->videoPicking;
    }

    public function setVideoPicking(string $videoPicking): static
    {
        $this->videoPicking = $videoPicking;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUrlVideo(): ?string
    {
        return $this->urlVideo;
    }

    public function setUrlVideo(string $urlVideo): static
    {
        $this->urlVideo = $urlVideo;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function setChannelId(?string $channelId): static
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function getChannelTitle(): ?string
    {
        return $this->channelTitle;
    }

    public function setChannelTitle(?string $channelTitle): static
    {
        $this->channelTitle = $channelTitle;

        return $this;
    }

    public function getVideoFrom(): ?string
    {
        return $this->videoFrom;
    }

    public function setVideoFrom(string $videoFrom): static
    {
        $this->videoFrom = $videoFrom;

        return $this;
    }

    public function getPublishedTime(): ?\DateTimeInterface
    {
        return $this->publishedTime;
    }

    public function setPublishedTime(?\DateTimeInterface $publishedTime): static
    {
        $this->publishedTime = $publishedTime;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }
}
