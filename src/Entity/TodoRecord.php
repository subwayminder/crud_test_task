<?php

namespace Subwayminder\CrudTestTask\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'todo_records')]
class TodoRecord
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id;
    #[ORM\Column(type: 'string')]
    private string $title;
    #[ORM\Column(type: 'text')]
    private string $description;
    #[ORM\Column(type: 'integer')]
    private int $list_id;
    #[ManyToOne(targetEntity: TodoList::class, inversedBy: 'records')]
    #[JoinColumn(name: 'list_id', referencedColumnName: 'id')]
    private TodoList $list;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $value): void
    {
        $this->title = $value;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $value): void
    {
        $this->description = $value;
    }
    public function setList(TodoList $list): void
    {
        $this->list = $list;
    }
    public function getList(): TodoList
    {
        return  $this->list;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}