<?php

namespace Subwayminder\CrudTestTask\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Subwayminder\CrudTestTask\Entity\TodoList;
use Subwayminder\CrudTestTask\Entity\TodoRecord;
use Subwayminder\CrudTestTask\Entity\User;
use Subwayminder\CrudTestTask\Requests\List\ListRecordRequest;
use Subwayminder\CrudTestTask\Requests\List\ListRecordUpdateRequest;

class RecordService
{
    private EntityRepository|ObjectRepository $repository;
    private EntityRepository|ObjectRepository $listRepository;
    public function __construct(
        private readonly EntityManager $entityManager,
        private readonly User|null $user
    )
    {
        $this->repository = $this->entityManager->getRepository(TodoRecord::class);
        $this->listRepository = $this->entityManager->getRepository(TodoList::class);
    }
    public function store(ListRecordRequest $request): TodoRecord|null
    {
        $list = $this->getTodoList($request->getListId());
        if (!$list) return null;
        $record = new TodoRecord();
        $record->setTitle($request->getTitle());
        $record->setDescription($request->getDescription());
        $record->setList($list);
        $this->entityManager->persist($record);
        $this->entityManager->flush();
        return $record;
    }
    public function update($id, ListRecordUpdateRequest $request): TodoRecord|null
    {
        /** @var TodoRecord $record */
        $record = $this->repository->find($id);
        if (!$record) return null;
        $list = $record->getList();
        if ($list->getUserId() !== $this->user->getId()) return null;
        $record->setTitle($request->getTitle());
        $record->setDescription($request->getDescription());
        $this->entityManager->persist($record);
        $this->entityManager->flush();
        return $record;
    }
    public function destroy($id): int|null
    {
        /** @var TodoRecord $record */
        $record = $this->repository->find($id);
        if (!$record) return null;
        $list = $record->getList();
        if ($list->getUserId() !== $this->user->getId()) return null;
        $id = $record->getId();
        $this->entityManager->remove($record);
        $this->entityManager->flush();
        return $id;
    }
    private function getTodoList($id): TodoList|null
    {
        return $this->listRepository->findOneBy([
            'id' => $id,
            'user_id' => $this->user->getId()
        ]);
    }
}