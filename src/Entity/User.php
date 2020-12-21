<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"user:read"}},
 *  collectionOperations={
 *  "get",
 *  "post"={
 *      "normalization_context"={"groups"={"user:post"}},
 *      "path"="/login/add",
 *  }
 * },
 * itemOperations={"get"}
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"parent:read","user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"parent:read","parent:full:read","user:read","user:post"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = ["ROLE_PARENT"];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:post"})
     */
    private $password;

    /**
     *  @SerializedName("password")
     */
    private $plainPassword;

    /**
     * @ORM\OneToOne(targetEntity=Teachers::class, inversedBy="user", cascade={"persist", "remove"})
     * @Groups({"user:read"})
     */
    private $teacher;

    /**
     * @ORM\OneToOne(targetEntity=Parents::class, inversedBy="user", cascade={"persist", "remove"})
     * @Groups({"user:read"})
     */
    private $parent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        // $roles[] = 'ROLE_PARENT';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

     /**
     * @see UserInterface
     */
    public function getPlainPassword(): string
    {
        return (string) $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getTeacher(): ?Teachers
    {
        return $this->teacher;
    }

    public function setTeacher(?Teachers $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getParent(): ?Parents
    {
        return $this->parent;
    }

    public function setParent(?Parents $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
