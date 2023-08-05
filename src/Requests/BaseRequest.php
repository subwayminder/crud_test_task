<?php

namespace Subwayminder\CrudTestTask\Requests;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    abstract protected function rules(): Collection;
    public function __construct(protected readonly ValidatorInterface $validator)
    {
        if ($this->autoValidateRequest()) {
            $this->validate();
        }
        $this->populate();
    }
    protected function autoValidateRequest(): bool
    {
        return true;
    }
    public function validate(): void
    {
        $request = $this->getRequest();
        $requestData = array_merge(
            $request->query->all(),
            $this->getBody()
        );
        $errors = $this->validator->validate($requestData, $this->rules());
        $messages = ['message' => 'Validation failed', 'errors' => []];
        /** @var $message ConstraintViolation  */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }
        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages, Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->send();
            exit;
        }
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        $request = $this->getRequest();
        $requestData = array_merge(
            $this->getBody(),
            $request->query->all()
        );
        foreach ($requestData as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    private function getBody(): array
    {
        $request = $this->getRequest();
        $body = [];
        try {
            $body = $request->toArray();
        } catch (\Exception) {
        }
        return $body;
    }
}