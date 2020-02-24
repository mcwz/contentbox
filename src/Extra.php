<?php

namespace Sheld\Contentbox;

class Extra{
    public $typeid;
    public $name;
    public $value;
    public $key;
    public $extra;

    public function __construct($typeid,$name,$key,$extra='',$value='')
    {
        $this->typeid=$typeid;
        $this->name=$name;
        $this->value=$value;
        $this->key=$key;
        $this->extra=$extra;
    }
}
