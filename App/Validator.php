<?php

namespace SIS\App;

class Validator
{

    public static function validate($callback)
    {

        if (is_callable($callback)) {
            return $callback;
        } else {

            [$validateName, $validateMethod] = explode('@', $callback);

            $validateName = "SIS\\App\\Validate\\" . $validateName;
            $validate = new $validateName();
            return [$validate, $validateMethod];
        }


    }

}