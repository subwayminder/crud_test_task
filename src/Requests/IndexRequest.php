<?php

namespace Subwayminder\CrudTestTask\Requests;

use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints;

class IndexRequest extends BaseRequest
{
    protected int $limit = 10;
    protected int $page = 1;
    public function getLimit(): int
    {
        return $this->limit;
    }
    public function getPage(): int
    {
        return $this->page;
    }

    protected function rules(): Collection
    {
        return new Collection([
            'limit' => [
                new Optional(
                    new Constraints\Regex(
                        pattern: '#[^0-9]#',
                        message: 'Limit value should be digit',
                        match: false
                    )
                ),
            ],
            'page' => [
                new Optional(
                    new Constraints\Regex(
                        pattern: '#[^0-9]#',
                        message: 'Limit value should be digit',
                        match: false
                    )
                ),
            ],
        ]);
    }
}