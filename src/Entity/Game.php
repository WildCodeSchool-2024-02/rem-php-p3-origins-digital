<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $cover = null;

    /**
     * @var Collection<int, Genres>
     */
    #[ORM\ManyToMany(targetEntity: Genres::class, inversedBy: 'games')]
    private Collection $genres;

    /**
     * @var Collection<int, Theme>
     */
    #[ORM\ManyToMany(targetEntity: Theme::class, inversedBy: 'games')]
    private Collection $themes;

    /**
     * @var Collection<int, Video>
     */
    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Video::class)]
    private Collection $videos;

    /**
     * @var Collection<int, PpgVideo>
     */
    #[ORM\OneToMany(mappedBy: 'game', targetEntity: PpgVideo::class)]
    private Collection $ppgVideos;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->ppgVideos = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Collection<int, Genres>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genres $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genres $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): static
    {
        if (!$this->themes->contains($theme)) {
            $this->themes->add($theme);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): static
    {
        $this->themes->removeElement($theme);

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setGame($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getGame() === $this) {
                $video->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PpgVideo>
     */
    public function getPpgVideos(): Collection
    {
        return $this->ppgVideos;
    }

    public function addPpgVideo(PpgVideo $ppgVideo): static
    {
        if (!$this->ppgVideos->contains($ppgVideo)) {
            $this->ppgVideos->add($ppgVideo);
            $ppgVideo->setGame($this);
        }

        return $this;
    }

    public function removePpgVideo(PpgVideo $ppgVideo): static
    {
        if ($this->ppgVideos->removeElement($ppgVideo)) {
            // set the owning side to null (unless already changed)
            if ($ppgVideo->getGame() === $this) {
                $ppgVideo->setGame(null);
            }
        }

        return $this;
    }
}
