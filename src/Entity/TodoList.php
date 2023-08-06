<?php

namespace Subwayminder\CrudTestTask\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name: 'todo_lists')]
class TodoList
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    private string $title;
    #[ORM\Column(type: 'integer')]
    private int $user_id;
    #[ManyToOne(targetEntity: User::class, inversedBy: 'lists')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;
    #[OneToMany(mappedBy: 'list', targetEntity: TodoRecord::class)]
    private Collection $records;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getRecords(): Collection
    {
        return $this->records;
    }
    public function getRecordsArray(): array
    {
        $result = [];
        foreach ($this->records as $record){
            /** @var TodoRecord $record */
            $result[] = $record->toArray();
        }
        return $result;
    }
}