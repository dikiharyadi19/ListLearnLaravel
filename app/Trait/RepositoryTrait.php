<?php

namespace App\Traits;

trait RepositoryTrait
{
    /**
     * Get number of records
     *
     * @return array
     */
    public function getNumber()
    {
        return $this->model->count();
    }

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function updateColumn($id, $input)
    {
        $this->model = $this->getById($id);

        foreach ($input as $key => $value) {
            $this->model->{$key} = $value;
        }

        return $this->model->save();
    }

    /**
     * Destroy a model.
     *
     * @param $model
     * @return mixed
     * @internal param $id
     */
    public function destroy($model)
    {
        return $model->delete();
    }

    /**
     * Get model by id.
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->where('id', $id)->firstOrFail();
    }

    /**
     * Get all the records
     *
     * @return array User
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Get number of the records
     *
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Store a new record.
     *
     * @param  $input
     * @return mixed
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * Update a record by id.
     *
     * @param  $id
     * @param  $input
     * @return mixed
     */
    public function update($id, $input, $updated_at = true)
    {
        $this->model = $this->getById($id);

        return $this->save($this->model, $input, $updated_at);
    }

    /**
     * Save the input's data.
     *
     * @param  $input
     * @return mixed
     * @internal param $model
     */
    public function save($model, $input, $updated_at = true)
    {
        $model->fill($input);
        if ($updated_at === false) {
            $model->timestamps = false;
        }
        $model->save();

        return $model;
    }

    /**
     * @param $input
     * @return mixed
     * @internal param $model
     */
    public function datatableQuery($input)
    {
        return $this->model->select($input);
    }

    /**
     * Get DatatableData With Relation
     *
     * @param $select
     * @param $with
     * @return mixed
     */
    public function datatableQueryWith($select, $with)
    {
        $model = $this->datatableQuery($select);

        return $model->with($with);
    }
}
