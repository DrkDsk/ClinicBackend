<?php

namespace App\Repositories\Contract;

use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface PersonRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $value): ?Person;

    public function findWithFields(array $search): Builder;

    public function search(string $query): Collection;
}
