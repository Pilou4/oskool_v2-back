<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 */
class Events
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"school:full:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:full:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"school:ful:read"})
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read"})
     */
    private $activity;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read"})
     */
    private $accompagnants;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read"})
     */
    private $meeting;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read"})
     */
    private $alert;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read"})
     */
    private $gear;

    /**
     * @ORM\ManyToOne(targetEntity=Schools::class, inversedBy="events")
     */
    private $schools;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(?string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getAccompagnants(): ?string
    {
        return $this->accompagnants;
    }

    public function setAccompagnants(?string $accompagnants): self
    {
        $this->accompagnants = $accompagnants;

        return $this;
    }

    public function getMeeting(): ?string
    {
        return $this->meeting;
    }

    public function setMeeting(?string $meeting): self
    {
        $this->meeting = $meeting;

        return $this;
    }

    public function getAlert(): ?string
    {
        return $this->alert;
    }

    public function setAlert(?string $alert): self
    {
        $this->alert = $alert;

        return $this;
    }

    public function getGear(): ?string
    {
        return $this->gear;
    }

    public function setGear(?string $gear): self
    {
        $this->gear = $gear;

        return $this;
    }

    public function getSchools(): ?Schools
    {
        return $this->schools;
    }

    public function setSchools(?Schools $schools): self
    {
        $this->schools = $schools;

        return $this;
    }
}
