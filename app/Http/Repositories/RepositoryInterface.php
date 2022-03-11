<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Create one record.
     * @param array $data
     * @return Model
     */
    public function create(array $data);

    /**
     * Return all
     * @return Collection
     */
    public function all();

    /**
     * Bulk insertion.
     * @param array $data
     * @return mixed
     */
    public function insert(array $data);

    /**
     * Update by id.
     * @param int $id
     * @param array $params
     * @return mixed
     */
    public function update(int $id, array $params = []);

    /**
     * Delete by id.
     * @param array $id
     * @return mixed
     */
    public function delete(array $id);

    /**
     * Find Record by id.
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * Get rows count.
     * @param array $where
     * @return mixed
     */
    public function count(array $where = []);

    /**
     * Truncate model
     * @return void
     */
    public function truncate();

    /**
     * Update all records of model
     * @param array $params
     * @return void
     */
    public function updateAll(array $params = []);
}
