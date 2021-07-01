<?php


namespace App\DAO\Traits;


trait ArrayMapToModel
{
    /**
     * @param $data array
     * @return array
     */
    public function mapToModel($data)
    {
        return array_map(function($item) {
            return new $this->model($item);
        }, $data);
    }
}