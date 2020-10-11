<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SchoolsRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=SchoolsRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"school:read"}},
 *      collectionOperations={"get"},
 *      itemOperations={
 *          "get"={
 *          "normalization_context"={"groups"={"school:full:read"}}
 *          }   
 *      } 
 * )
 * @ApiFilter(SearchFilter::class,properties={"classe":"exact"})
 */
class Schools
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"school:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"school:full:read"})
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"school:full:read"})
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:full:read"})
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"school:full:read"})
     */
    private $students_number;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read"})
     */
    private $agenda;

    /**
     * @ORM\OneToMany(targetEntity=Events::class, mappedBy="schools")
     * @Groups({"school:full:read"})
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Classes::class, mappedBy="schools",orphanRemoval=true)
     * @Groups({"school:full:read"})
     */
    private $classes;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->classes = new ArrayCollection();
    }

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStudentsNumber(): ?int
    {
        return $this->students_number;
    }

    public function setStudentsNumber(?int $students_number): self
    {
        $this->students_number = $students_number;

        return $this;
    }

    public function getAgenda(): ?string
    {
        return $this->agenda;
    }

    public function setAgenda(?string $agenda): self
    {
        $this->agenda = $agenda;

        return $this;
    }

    /**
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setSchools($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getSchools() === $this) {
                $event->setSchools(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Classes[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setSchools($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): self
    {
        if ($this->classes->contains($class)) {
            $this->classes->removeElement($class);
            // set the owning side to null (unless already changed)
            if ($class->getSchools() === $this) {
                $class->setSchools(null);
            }
        }

        return $this;
    }
}
