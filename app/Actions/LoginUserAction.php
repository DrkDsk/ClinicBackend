<?php

namespace App\Actions;

use App\Models\User;
use App\Repositories\Contract\PersonRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

readonly class LoginUserAction
{
    public function __construct(
        private PersonRepositoryInterface $personRepository
    )
    {
    }

    /**
     * @throws AuthenticationException
     */
    public function __invoke(string $email, string $password): User
    {
        $person = $this->personRepository->findByEmail($email);

        if (!$person || !Hash::check($password, $person->user->password)) {
            throw new AuthenticationException("Credenciales incorrectas");
        }

        return $person->user;
    }
}
