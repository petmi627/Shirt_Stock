<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 22.12.17
 * Time: 12:58
 */

namespace App\Core\Mvc\Controller;


use App\Core\Mvc\View\JsonModel;

abstract class AbstractRESTfulController
{
    public function get()
    {
        new JsonModel(["message", "Request method not allowed"], 405);
    }

    public function create()
    {
        new JsonModel(["message", "Request method not allowed"], 405);
    }

    public function update()
    {
        new JsonModel(["message", "Request method not allowed"], 405);
    }

    public function delete()
    {
        new JsonModel(["message", "Request method not allowed"], 405);
    }
}