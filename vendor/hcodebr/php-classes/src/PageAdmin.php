<?php

namespace Hcode;

//a herança(extends) reaproveita todos metodos que sao protegidos e publicos da classe Page
class PageAdmin extends Page
{
    public function __construct($opts = array(), $tpl_dir = "/views/admin/")
    {
        parent::__construct($opts, $tpl_dir);
    }
}
