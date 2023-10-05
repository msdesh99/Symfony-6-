<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name:"user")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    //#[ORM\Column (name:"id")]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
   // #[ORM\Column(name:"username",length: 255)]
    #[Assert\NotBlank()]
    private ?string $username = null;

   /* #[ORM\Column(length:255)]
    #[Assert\Blank()]
    #[Assert\Image()]
    private ?string $userImage = null; */
    
    #[ORM\Column(length:255)]
    //#[ORM\Column(name:"avatar",length:255)]
    #[Assert\Blank()]
    #[Assert\File(maxSize:'250K',extensions:'jpg' )]
    private ?string $avatar = null;
    
    #[ORM\Column(length: 255)]
    //#[ORM\Column(name:"attach",length: 255)]
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
    //#[ORM\Column(name:"email", length: 255, nullable: true)]
    #[Assert\Email()]
    private ?string $email = null;
 
    /*This mapping can be done with an Object Relational Mapping (ORM) tool. 
    Symfony provides a separate bundle, DoctrineBundle, 
    which integrates Symfony with third party PHP database ORM tool, Doctrine. */
    //https://symfony.com/doc/current/doctrine/associations.html
   // #[ORM\Column(name:"department")]
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Department', inversedBy:"Department")]
    
    private $department;


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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department=null): self
    {
        $this->department = $department;

        return $this;
    }
}
