<?php
namespace App\Libraries\Captcha;

class CaptchaFactory
{

    public static function Captcha($name, $config = [])
    {

        $name = strtolower($name);
        switch ($name) {

            case 'invertedword':
                return new InvertedWord($config);
            case 'mixchar':
                return new MixChar($config);
        }
    }

}