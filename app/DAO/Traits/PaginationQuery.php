<?php


namespace App\DAO\Traits;


trait PaginationQuery
{
    public function paginate(&$query, $page)
    {
        if ($page) {
            $query->offset(25 * ($page - 1));
        }
    }
}