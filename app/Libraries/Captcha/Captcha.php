<?php
namespace App\Libraries\Captcha;

interface Captcha

{

    public function getCaptcha();

    public function captchaValue();

    public function judgeCaptcha($captcha_source,$captcha);

}