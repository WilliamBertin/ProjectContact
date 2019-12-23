<?php
namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * *@ORM\Entity*@ORM\Table(name="contact")
 */
class Contact
{

    /** 
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    public $id;

    /**
    * @ORM\Column(name="firstname", type="text")
    */
    public $firstname;

    /**
     * @ORM\Column(name="lastname", type="text")
     */
    public $lastname;

    /**
     * @ORM\Column(name="fullname", type="text")
     */
    public $fullname;

    /**
     * @ORM\Column(name="email", type="text")
     */
    public $email;

    public function getId(): int 
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
        return $this->firstname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
        return $this->lastname;
    }

    public function setFullname(string $fullname)
    {
        $this->fullname = $fullname;
        return $this->fullname;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this->email;
    }

}