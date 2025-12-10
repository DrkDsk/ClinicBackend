<?php

namespace App\Repositories\Eloquent;

use App\Models\Person;
use App\Repositories\Contract\PersonRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EloquentPersonRepository extends BaseRepository implements PersonRepositoryInterface
{

    public function __construct(Person $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $value): ?Person
    {
        return $this->model->query()->where("email", $value)->first();
    }

    // CALL to Person -> scopeSearch
    public function search(string $query): Collection
    {
        return $this->model->search($query)->get();
    }

    public function findWithFields(array $search): Builder
    {
        $query = $this->model->newQuery();

        return $query->where(function ($query) use ($search) {
            foreach ($search as $key => $value) {
                $query->orWhere($key, $value);
            }
        });
    }
}

