<?php

namespace Subwayminder\CrudTestTask\Requests\Auth;

use Subwayminder\CrudTestTask\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class RegisterRequest extends BaseRequest
{
    protected string $email;
    protected string $password;
    protected string $first_name;
    protected string $last_name;

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
    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }
    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
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
                    [
                        new Type('string'),
                        new Length(
                            min: 8,
                            max: 20
                        )
                    ]
                ),
            ],
            'first_name' => [
                new Required(
                    new Type('string'),
                ),
            ],
            'last_name' => [
                new Required(
                    new Type('string'),
                ),
            ],
        ]);
    }
}