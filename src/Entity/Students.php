<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StudentsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StudentsRepository::class)
 *  @ApiResource(
 *      attributes={
 *      "order"={"lastname":"ASC"}
 *      },
 *      paginationItemsPerPage=2,
 *      normalizationContext={"groups"={"student:read"}},
 *      collectionOperations={
 *      "get",
 *      "post"={
 *          "normalization_context"={"groups"={"student:post"}},
 *          "controller"=App\Controller\Api\CreateStudentController::class
 *          }
 *      },
 *      itemOperations={
 *      "get"={
 *      "normalization_context"={"groups"={"student:full:read"}},
 *     },
 *      "put"={
 *          "security"="is_granted('EDIT_STUDENT',object)"
 *      },
 *      "delete"={
 *          "security"="is_granted('EDIT_STUDENT',object)"
 *      }
 *  }
 * )
 */
class Students
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"school:full:read","parent:read","student:read","student:full:read","parent:full:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:full:read","parent:read","student:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:full:read","parent:read","student:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"school:full:read","parent:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"school:full:read","parent:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"school:full:read","parent:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $level;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read","parent:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $hobbies;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read","parent:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $health;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"school:full:read","parent:read","student:full:read","student:post","parent:full:read", "user:read"})
     */
    private $image_right;

    /**
     * @ORM\ManyToOne(targetEntity=Classes::class, inversedBy="students",)
     * @Groups({"student:full:read","parent:full:read"})
     */
    private $classes;

    /**
     * @ORM\ManyToMany(targetEntity=Parents::class, inversedBy="students")
     * @Groups({"student:full:read"})
     */
    private $parents;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getHobbies(): ?string
    {
        return $this->hobbies;
    }

    public function setHobbies(?string $hobbies): self
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    public function getHealth(): ?string
    {
        return $this->health;
    }

    public function setHealth(?string $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getImageRight(): ?string
    {
        return $this->image_right;
    }

    public function setImageRight(?string $image_right): self
    {
        $this->image_right = $image_right;

        return $this;
    }

    public function getClasses(): ?Classes
    {
        return $this->classes;
    }

    public function setClasses(?Classes $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @return Collection|Parents[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Parents $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
        }

        return $this;
    }

    public function removeParent(Parents $parent): self
    {
        if ($this->parents->contains($parent)) {
            $this->parents->removeElement($parent);
        }

        return $this;
    }
}
