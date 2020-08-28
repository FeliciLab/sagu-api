<?php

namespace App\Http\Controllers;

use App\Http\JWT\JWTWrapper;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function toArray($obj)
    {
        if (is_object($obj)) $obj = (array)$obj;

        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = $this->toArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }
}
