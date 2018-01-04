<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 22.12.17
 * Time: 12:58
 */

namespace App\Core\Mvc\View;


use App\Core\Router\Response;

class JsonModel
{
    private $statusCode;

    private $json;

    public function __construct($data, $statusCode = 200)
    {
        $this->json = json_encode($data);
        $this->statusCode = $statusCode;

        $this->render();
    }

    public function render()
    {
        header('Content-Type: application/json');
        Response::http_response_code($this->statusCode);

        echo $this->json;
    }
}