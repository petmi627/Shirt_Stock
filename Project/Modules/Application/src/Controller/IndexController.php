<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 20.12.17
 * Time: 18:43
 */

namespace Application\Controller;


use App\Core\Mvc\Controller\AbstractActionController;
use App\Core\Mvc\View\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(APPLICATION_MODULE_ROOT . "/view/index/index.phtml");
    }
}