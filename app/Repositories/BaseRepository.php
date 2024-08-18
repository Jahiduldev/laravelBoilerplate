<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IBaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->model::all();
    }
    /**
     * @param mixed $id
     *
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     * @return Model|null
     */
    public function findFirstBy(string $fieldName, mixed $value): ?Model
    {
        return $this->model->where($fieldName, $value)->first();
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param mixed $id
     * @param array $data
     *
     * @return Model
     */
    public function update($id, array $data): Model
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $model = $this->find($id);
        $model->delete();
    }
    /**
     * @param mixed $id
     *
     * @return void
     */
    public function deleteAll(string $fieldName, mixed $id): void
    {
        $model = $this->model->where($fieldName, $id);
        $model->delete();
    }
}
