<?php

namespace Subwayminder\CrudTestTask\Requests\Auth;

use Subwayminder\CrudTestTask\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class LoginRequest extends BaseRequest
{
    protected string $email;
    protected string $password;
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    protected function rules(): Collection
    {
        return new Collection([
            'email' => [
                new Required(
                    [
                        new Email()
                    ]
                ),
            ],
            'password' => [
                new Required(
                    new Type('string'),
                ),
            ],
        ]);
    }
}