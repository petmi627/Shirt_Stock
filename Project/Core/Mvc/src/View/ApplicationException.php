<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 22.12.17
 * Time: 18:39
 */

namespace App\Core\Mvc\View;


class ApplicationException
{
    public static function execute($statusCode, $msg)
    {
        return new JsonModel(['message' => $msg], $statusCode);
    }
}