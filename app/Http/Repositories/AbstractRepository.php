<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * Should be overridden on child classes.
     * AbstractRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return $this->model::all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        return $this->model::query()->create($data);
    }

    /**
     * @inheritDoc
     */
    public function insert(array $data)
    {
        return $this->model::query()->insert($data);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $params = [])
    {
        $record = $this->model::query()->findOrFail($id);

        $record->update($params);

        return $record;
    }

    /**
     * @inheritDoc
     */
    public function delete(array $ids)
    {
        return $this->model::query()->whereIn('id', $ids)->delete();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id)
    {
        return $this->model::query()->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function count(array $where = [])
    {
        return $this->model::query()->where($where)->count();
    }

    /**
     * {@inheritDoc}
     */
    public function truncate()
    {
        $this->model::query()->truncate();
    }

    /**
     * {@inheritDoc}
     */
    public function updateAll(array $params = [])
    {
        $this->model::query()->update($params);
    }
}
