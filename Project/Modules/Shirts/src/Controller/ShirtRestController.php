<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 22.12.17
 * Time: 20:18
 */

namespace Shirts\Controller;


use App\Core\Mvc\Controller\AbstractRESTfulController;
use App\Core\Mvc\View\JsonModel;
use Shirts\Repository\ShirtRepository;

class ShirtRestController extends AbstractRESTfulController
{
    /**
     * @var ShirtRepository
     */
    private $shirtRepository;

    /**
     * @param mixed $shirtRepository
     */
    public function setShirtRepository($shirtRepository)
    {
        $this->shirtRepository = $shirtRepository;
    }

    public function get()
    {
        if (isset($_GET["q"])) {
            if ($this->getId() != null) {
                $result = $this->shirtRepository->getShirt($this->getId(), $this->getLanguage());

                return new JsonModel($result);
            }

            return new JsonModel(["message" => "Shirt not found!"], 404);
        }

        return new JsonModel($this->shirtRepository->getShirts($this->getLanguage()));
    }

    public function create()
    {
        if (isset($_POST["save_shirt"])) {
            $input = $this->checkInput();
            if (isset($input["message"])) {
                return new JsonModel(["messages" => $input["message"]], 400);
            }

            $result = $this->shirtRepository->saveShirt($input);
            if ($result) {
                return new JsonModel(["message" => 'Shirt was created'], 201);
            }
        }

        return new JsonModel(["message" => 'Nothing to do']);
    }

    private function getId()
    {
        $q = $_GET["q"];
        if (!$this->shirtRepository->checkShirt($q)) {
            return null;
        }

        return $q;
    }

    private function getLanguage()
    {
        if (isset($_GET["language"])) {
            $language = $_GET["language"];
            if (!in_array($language, ["en", "fr", "de"])) {
                 return "en";
            }

            return $_GET["language"];
        }

        return "en";
    }

    private function checkInput()
    {
        $data = [];

        if (isset($_FILES["image"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $allowed =  array('gif','png' ,'jpg', 'jpeg', "JPEG", "JPG", "PNG", "GIF");
                $filename = $_FILES['image']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!in_array($ext,$allowed) ) {
                    $data["message"][] = "Only gif,png,jpg,jpeg file types allowed";
                } else {
                    $data["image"] = "data:image/jpeg;base64," . base64_encode(file_get_contents($_FILES["image"]["tmp_name"]));
                }
            } else {
                $data["message"][] = "This doesn't seems to be an image";
            }
        } else {
            $data["message"][] = "Image is required";
        }

        if (isset($_POST["size"])) {
            $size = strtoupper($_POST["size"]);
            if (!in_array($size, ["XS", "S", "M", "L", "XL", "XXL"])) {
                $data["message"][] = "Size is invalid";
            } else {
                $data["size"] = $size;
            }
        } else {
            $data["message"][] = "Size is required";
        }

        if (isset($_POST["price"])) {
           $price = floatval(sprintf("%.2f", str_replace(",", ".", $_POST["price"])));
           if (is_float($price)) {
               $data["price"] = $price;
           } else {
               $data["message"][] = "Price is invalid";
           }
        } else {
            $data["message"][] = "Price is required";
        }

        if (isset($_POST["name_en"])) {
            $name = trim(strip_tags($_POST["name_en"]));
            if (strlen($name) > 3) {
                $data["name"][] = ["language" => 'en', 'name' => $name];
            } else {
                $data["message"][] = "English name need at least 3 characters";
            }
        } else {
            $data["message"][] = "English name was not set";
        }

        if (isset($_POST["name_de"])) {
            $name = trim(strip_tags($_POST["name_de"]));
            if (strlen($name) > 3) {
                $data["name"][] = ["language" => 'de', 'name' => $name];
            } else {
                $data["message"][] = "German name need at least 3 characters";
            }
        } else {
            $data["message"][] = "German name was not set";
        }

        if (isset($_POST["name_fr"])) {
            $name = trim(strip_tags($_POST["name_fr"]));
            if (strlen($name) > 3) {
                $data["name"][] = ["language" => 'fr', 'name' => $name];
            } else {
                $data["message"][] = "French name need at least 3 characters";
            }
        } else {
            $data["message"][] = "French name was not set";
        }

        return $data;
    }


}