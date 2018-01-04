<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 31.12.17
 * Time: 05:25
 */

namespace Shirts\Controller;


use App\Core\Mvc\Controller\AbstractActionController;
use App\Core\Mvc\View\ViewModel;

class ShirtController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(SHIRT_MODULE_ROOT . "/view/index/index.phtml");
    }

    public function addAction()
    {
        return new ViewModel(SHIRT_MODULE_ROOT . "/view/modify/add.phtml");
    }
}