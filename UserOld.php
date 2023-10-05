<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $username = null;

   /* #[ORM\Column(length:255)]
    #[Assert\Blank()]
    #[Assert\Image()]
    private ?string $userImage = null; */
    
    #[ORM\Column(length:255)]
    #[Assert\Blank()]
    #[Assert\File(maxSize:'250K',extensions:'jpg' )]
    private ?string $avatar = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\Blank()]
    #[Assert\File(maxSize: '1024k', extensions: [
        'pdf',
        'xml' => ['text/xml', 'application/xml'],
        'docx']) ]
    private ?string $attach = null;

   /* #[ORM\Column]
    private ?int $userid = null;
   */ 
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email()]
    private ?string $email = null;

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

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserImage(): ?string
    {
        return $this->userImage;
    }

    public function setUserImage(string $userImage): self
    {
        $this->userImage = $userImage;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAttach(): ?string
    {
        return $this->attach;
    }

    public function setAttach(string $attach): self
    {
        $this->attach = $attach;

        return $this;
    }
}
