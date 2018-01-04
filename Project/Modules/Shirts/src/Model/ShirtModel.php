<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 31.12.17
 * Time: 04:16
 */

namespace Shirts\Model;


class ShirtModel implements  \JsonSerializable
{
    public $id;
    public $price;
    public $size;
    public $image;
    public $title;
    public $language;

    public function jsonSerialize()
    {
        return [
            'id'        => $this->id,
            'name'      => $this->title,
            'price'     => sprintf("%.2f", $this->price),
            'size'      => $this->size,
            'image'     => $this->image,
            'language'  => $this->language,
        ];
    }
}