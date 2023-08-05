<?php

namespace Subwayminder\CrudTestTask\Controllers;

use Subwayminder\CrudTestTask\Requests\IndexRequest;
use Subwayminder\CrudTestTask\Requests\List\ListRequest;
use Subwayminder\CrudTestTask\Services\ListService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListController
{
    public function __construct(public readonly ListService $listService)
    {
    }
    public function index(IndexRequest $request): void
    {
        $data = $this->listService->index(
            limit: $request->getLimit(),
            page: $request->getPage()
        );
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
    public function show($id): void
    {
        $data = $this->listService->show($id);
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
    public function create(ListRequest $request): void
    {
        $data = $this->listService->store($request);
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
    public function update($id, ListRequest $request): void
    {
        $data = $this->listService->update($id, $request);
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
    public function delete($id): void
    {
        $data = $this->listService->destroy($id);
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
}