<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Quizz>
     */
    #[ORM\ManyToMany(targetEntity: Quizz::class, inversedBy: 'questions')]
    private Collection $quizz;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Reponse>
     */
    #[ORM\ManyToMany(targetEntity: Reponse::class, mappedBy: 'question')]
    private Collection $reponses;

    public function __construct()
    {
        $this->quizz = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Quizz>
     */
    public function getQuizzId(): Collection
    {
        return $this->quizz;
    }

    public function addQuizzId(Quizz $quizzId): static
    {
        if (!$this->quizz->contains($quizzId)) {
            $this->quizz->add($quizzId);
        }

        return $this;
    }

    public function removeQuizzId(Quizz $quizzId): static
    {
        $this->quizz->removeElement($quizzId);

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

    /**
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
            $reponse->addQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): static
    {
        if ($this->reponses->removeElement($reponse)) {
            $reponse->removeQuestion($this);
        }

        return $this;
    }
}
