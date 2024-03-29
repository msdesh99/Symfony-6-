<?php
//added in github
namespace App\Entity;

use App\Repository\LoginRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

//https://www.youtube.com/watch?v=Bo0guUbL5uo
//http://localhost/myproject8.2/public/index.php/login --- url to execute
#[ORM\Entity(repositoryClass: LoginRepository::class)]
//#[ORM\Table]
//#[ORM\Table(name:"login")]

class Login implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    //#[ORM\Column(type:"integer")]

    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    //#[ORM\Column(type:"string",length: 180, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Unique()]

    private ?string $username = null;

    #[ORM\Column]
    //#[ORM\Column(name:"string")]

    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    //#[ORM\Column(name:"string")]
    #[Assert\NotBlank()]

    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
