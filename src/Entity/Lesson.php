<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 */
class Lesson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // src/Entity/Lesson.php

    /**
     * @Assert\GreaterThan("today UTC", message = "La date doit être dans le futur.")
     * @ORM\Column(type="date")
     */
    private $dateLesson;

    /**
     * @Assert\LessThan(propertyPath = "endHour", message = "Le cours doit commencer avant l'heure de fin.")
     * @ORM\Column(type="time")
     */
    private $startHour;
    
    /**
     * @ORM\Column(type="time")
     */
    private $endHour;

    /**
     * @Assert\NotBlank
     * @Assert\Positive(message="Le nombre de participant doit être supérieur à {{ compared_value }}.")
     * @ORM\Column(type="smallint")
     */
    private $peopleNumber;

    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="lesson")
     */
    private $participants;

    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", options={"default" :false})
     */
    private $isVisible;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLesson(): ?\DateTimeInterface
    {
        return $this->dateLesson;
    }

    public function setDateLesson(\DateTimeInterface $dateLesson): self
    {
        $this->dateLesson = $dateLesson;

        return $this;
    }

    public function getStartHour(): ?\DateTimeInterface
    {
        return $this->startHour;
    }

    public function setStartHour(\DateTimeInterface $startHour): self
    {
        $this->startHour = $startHour;

        return $this;
    }

    public function getEndHour(): ?\DateTimeInterface
    {
        return $this->endHour;
    }

    public function setEndHour(\DateTimeInterface $endHour): self
    {
        $this->endHour = $endHour;

        return $this;
    }

    public function getPeopleNumber(): ?int
    {
        return $this->peopleNumber;
    }

    public function setPeopleNumber(int $peopleNumber): self
    {
        $this->peopleNumber = $peopleNumber;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setLesson($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getLesson() === $this) {
                $participant->setLesson(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

}
