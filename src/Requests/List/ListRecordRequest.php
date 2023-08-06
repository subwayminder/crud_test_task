<?php

namespace Subwayminder\CrudTestTask\Requests\List;

use Subwayminder\CrudTestTask\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class ListRecordRequest extends BaseRequest
{
    protected string $title;
    protected string $description;
    protected string $list_id;

    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getListId(): int
    {
        return $this->list_id;
    }

    protected function rules(): Collection
    {
        return new Collection([
            'title' => [
                new Required(
                    [
                        new Type('string'),
                        new Length(
                            min: 5,
                            max: 50
                        )
                    ]
                ),
            ],
            'description' => [
                new Required(
                    [
                        new Type('string'),
                        new Length(
                            min: 10,
                            max: 200
                        )
                    ]
                ),
            ],
            'list_id' => [
                new Required(
                    [
                        new Type('integer'),
                    ]
                ),
            ],
        ]);
    }
}