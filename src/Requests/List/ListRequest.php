<?php

namespace Subwayminder\CrudTestTask\Requests\List;

use Subwayminder\CrudTestTask\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class ListRequest extends BaseRequest
{
    protected string $title;

    public function getTitle(): string
    {
        return $this->title;
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
        ]);
    }
}