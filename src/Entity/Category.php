<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Vich\Uploadable]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'poster_file', fileNameProperty: 'image')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DatetimeInterface $updatedAt = null;

    /**
     * @var Collection<int, Video>
     */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Video::class, orphanRemoval: true)]
    private Collection $video;

    /**
     * @var Collection<int, PpgVideo>
     */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: PpgVideo::class)]
    private Collection $ppgVideos;



     * @var Collection<int, Reponse>
     */
    #[ORM\ManyToMany(targetEntity: Reponse::class, mappedBy: 'category')]
    private Collection $reponses;

    public function __construct()
    {
        $this->video = new ArrayCollection();
        $this->ppgVideos = new ArrayCollection();
        $this->reponses = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(Video $video): static
    {
        if (!$this->video->contains($video)) {
            $this->video->add($video);
            $video->setCategory($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->video->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getCategory() === $this) {
                $video->setCategory(null);
            }
        }

        return $this;
    }

    public function setImageFile(File $image = null): Category
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return \DateTimeInterface|null*/
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
            $ppgVideo->setCategory($this);
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): static
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->addCategory($this);
        }

        return $this;
    }

    public function removePpgVideo(PpgVideo $ppgVideo): static
    {
        if ($this->ppgVideos->removeElement($ppgVideo)) {
            // set the owning side to null (unless already changed)
            if ($ppgVideo->getCategory() === $this) {
                $ppgVideo->setCategory(null);
            }
    public function removeReponse(Reponse $reponse): static
    {
        if ($this->reponses->removeElement($reponse)) {
            $reponse->removeCategory($this);
        }

        return $this;
    }
}
