<?php

namespace Subwayminder\CrudTestTask\Controllers;

use Subwayminder\CrudTestTask\Requests\List\ListRecordRequest;
use Subwayminder\CrudTestTask\Requests\List\ListRecordUpdateRequest;
use Subwayminder\CrudTestTask\Services\RecordService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RecordController
{
    public function __construct(private readonly RecordService $recordService)
    {
    }

    public function create(ListRecordRequest $request): void
    {
        $record = $this->recordService->store($request);
        if ($record === null) (new JsonResponse(null, Response::HTTP_NOT_FOUND))->send();
        (new JsonResponse([
            'id' => $record->getId(),
            'title' => $record->getTitle(),
            'description' => $record->getDescription()
        ], Response::HTTP_OK))->send();
    }
    public function update($id, ListRecordUpdateRequest $request): void
    {
        $record = $this->recordService->update($id, $request);
        if ($record === null) (new JsonResponse(null, Response::HTTP_NOT_FOUND))->send();
        (new JsonResponse([
            'id' => $record->getId(),
            'title' => $record->getTitle(),
            'description' => $record->getDescription()
        ], Response::HTTP_OK))->send();
    }
    public function delete($id): void
    {
        $recordId = $this->recordService->destroy($id);
        if ($recordId === null) (new JsonResponse(null, Response::HTTP_NOT_FOUND))->send();
        (new JsonResponse(['id' => $recordId], Response::HTTP_OK))->send();
    }
}