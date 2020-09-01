<?php


namespace App\DAO\Traits;


trait ArrayMapToModel
{
    public function mapToModel($data)
    {
        return array_map(function($item) {
            return new $this->model($item);
        }, $data);
    }
}