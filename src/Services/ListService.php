<?php

namespace Subwayminder\CrudTestTask\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ObjectRepository;
use Subwayminder\CrudTestTask\Entity\TodoList;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Subwayminder\CrudTestTask\Entity\User;
use Subwayminder\CrudTestTask\Requests\List\ListRequest;

class ListService
{
    private EntityRepository|ObjectRepository $repository;
    public function __construct(
        public readonly EntityManager $entityManager,
        public readonly User $user
    )
    {
        $this->repository = $this->entityManager->getRepository(TodoList::class);
    }
    public function index(int $limit = 10, int $page = 1): array
    {
        $response = [];
        $query = $this->repository->createQueryBuilder('l');
        $query->where('l.user_id = ?1')->setParameter(1, $this->user->getId());
        $paginator = new Paginator($query->getQuery());
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($page-1))
            ->setMaxResults($limit);
        foreach ($paginator as $list)
        {
            /** @var TodoList $list */
            $response[] = [
                'id' => $list->getId(),
                'title' => $list->getTitle(),
            ];
        }
        return $response;
    }
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function store(ListRequest $request): TodoList|null
    {
        $list = new TodoList();
        $list->setTitle($request->getTitle());
        $list->setUser($this->user);
        $this->entityManager->persist($list);
        $this->entityManager->flush();
        return $list;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update($id, ListRequest $request): TodoList|null
    {
        /** @var TodoList $list */
        $list = $this->repository->find($id);
        $list->setTitle($request->getTitle());
        $this->entityManager->persist($list);
        $this->entityManager->flush();
        return $list;
    }
    public function show($id): TodoList|null
    {
        /** @var TodoList|null $list */
        $list = $this->repository->findOneBy([
            'user_id' => $this->user->getId(),
            'id' => $id
        ]);
        return $list ?: null;
    }
    public function destroy($id): TodoList|null
    {
        $list = $this->repository->findOneBy([
            'id' => $id,
            'user_id' => $this->user->getId()
        ]);
        if (!$list) return null;
        $this->entityManager->persist($list);
        $this->entityManager->flush();
        return $list;
    }
}