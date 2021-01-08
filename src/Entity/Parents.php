<?php

namespace App\Entity;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParentsRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ParentsRepository::class)
 * @ApiResource(
 *      attributes={
 *      "order"={"lastname":"ASC"}
 *      },
 *      paginationItemsPerPage=2,
 *      normalizationContext={"groups"={"parent:read"}},
 *      collectionOperations={
 *      "get",
 *      "post"={
 *          "normalization_context"={"groups"={"parent:post"}},
 *          "controller"=App\Controller\Api\CreateParentController::class
 *          }
 *      },
 *      itemOperations={
 *      "get"={
 *      "normalization_context"={"groups"={"parent:full:read"}}
 *      },
 *      "put"={
 *          "security"="is_granted('EDIT_PARENT',object)"
 *      },
 *      "delete"={
 *          "security"="is_granted('EDIT_PARENT',object)"
 *      }
 *  }
 * )
 *  
 */
class Parents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"parent:read","parent:full:read", "student:full:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"parent:read","parent:full:read","parent:post","student:full:read","user:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"parent:read","parent:full:read","parent:post","student:full:read","user:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="text")
     * @Groups({"parent:read","parent:full:read","parent:post","student:full:read","user:read"})
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"parent:read","parent:full:read","parent:post","student:full:read","user:read"})
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"parent:read","parent:full:read","parent:post","student:full:read","user:read"})
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"parent:read","parent:full:read","parent:post","student:full:read","user:read"})
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity=Students::class, mappedBy="parents")
     * @Groups({"parent:read","parent:full:read","user:read"})
     */
    private $students;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="parent", cascade={"persist", "remove"})
     * @Groups({"parent:read","parent:full:read"})
     */
    private $user;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Students[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Students $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addParent($this);
        }

        return $this;
    }

    public function removeStudent(Students $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeParent($this);
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

        // set (or unset) the owning side of the relation if necessary
        $newParent = null === $user ? null : $this;
        if ($user->getParent() !== $newParent) {
            $user->setParent($newParent);
        }

        return $this;
    }
}
