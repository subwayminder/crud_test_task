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
        $data = [];
        $list = $this->listService->show($id);
        if ($list) {
            $data = [
                'id' => $list->getId(),
                'title' => $list->getTitle(),
                'records' => $list->getRecordsArray()
            ];
        }
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
    public function create(ListRequest $request): void
    {
        $data = [];
        $list = $this->listService->store($request);
        if ($list) {
            $data = [
                'id' => $list->getId(),
                'title' => $list->getTitle(),
            ];
        }
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
    public function update($id, ListRequest $request): void
    {
        $data = [];
        $list = $this->listService->update($id, $request);
        if ($list) {
            $data = [
                'id' => $list->getId(),
                'title' => $list->getTitle(),
            ];
        }
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
    public function delete($id): void
    {
        $data = [];
        $list = $this->listService->destroy($id);
        if ($list) {
            $data = [
                'id' => $list->getId(),
                'title' => $list->getTitle(),
            ];
        }
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->send();
    }
}