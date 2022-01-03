<?php

namespace Hcode;

class Model
{
    private $values = [];

    //metodo magico (só é invocado qdo o nome nao existe)
    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);

        $fielName = substr($name, 3, strlen($name));

        switch ($method) {

            case "get":
                return $this->values[$fielName];
                break;

            case "set":
                return $this->values[$fielName] = $args[0];
                break;
        }
    }

    public function setData($data = array())
    {
        foreach ($data as $key => $value) {

            $this->{"set" . $key}($value);
        }
    }

    public function getValues()
    {
        return $this->values;
    }
}
