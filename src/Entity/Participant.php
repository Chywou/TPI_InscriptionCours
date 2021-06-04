<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern="/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð \-']+$/",
     *      htmlPattern=false,
     *      message="Veuillez entrer un nom valide")  
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern="/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð \-']+$/",
     *      htmlPattern=false,
     *      message="Veuillez entrer un prénom valide")  
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=50)
     */
    private $dogName;

    /**
     * @ORM\ManyToOne(targetEntity=Lesson::class, inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lesson;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getDogName(): ?string
    {
        return $this->dogName;
    }

    public function setDogName(string $dogName): self
    {
        $this->dogName = $dogName;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }
}
