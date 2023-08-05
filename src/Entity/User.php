<?php

namespace Subwayminder\CrudTestTask\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string', unique: true)]
    private string $email;
    #[ORM\Column(type: 'string')]
    private string $password_hash;
    #[ORM\Column(type: 'string')]
    private string $first_name;
    #[ORM\Column(type: 'string')]
    private string $last_name;
    #[OneToMany(mappedBy: 'user', targetEntity: TodoList::class)]
    private Collection $lists;

    public function getId(): int
    {
        return $this->id;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }
    public function setPassword(string $password): void
    {
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
    }
    public function getFirstName(): string
    {
        return $this->first_name;
    }
    public function setFirstName(string $firstName): void
    {
        $this->first_name = $firstName;
    }
    public function getLastName(): string
    {
        return $this->last_name;
    }
    public function setLastName(string $lastName): void
    {
        $this->last_name = $lastName;
    }
}