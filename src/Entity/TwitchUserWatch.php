<?php

namespace App\Entity;

use App\Repository\TwitchUserWatchRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TwitchUserWatchRepository::class)]
class TwitchUserWatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_live = null;

    #[ORM\Column(nullable: true)]
    private ?int $game_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $game_name = null;

    #[ORM\Column(nullable: true)]
    private ?string $video_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

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

    public function isLive(): ?bool
    {
        return $this->is_live;
    }

    public function setLive(?bool $is_live): static
    {
        $this->is_live = $is_live;

        return $this;
    }

    public function getGameId(): ?int
    {
        return $this->game_id;
    }

    public function setGameId(?int $game_id): static
    {
        $this->game_id = $game_id;

        return $this;
    }

    public function getGameName(): ?string
    {
        return $this->game_name;
    }

    public function setGameName(?string $game_name): static
    {
        $this->game_name = $game_name;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->video_id;
    }

    public function setVideoId(?string $video_id): static
    {
        $this->video_id = $video_id;

        return $this;
    }
}
