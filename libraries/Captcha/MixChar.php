<?php
namespace Libraries\Captcha;

class MixChar extends AbstractCaptcha implements Captcha
{
    private $_config = [
        'fontfile' => '/opt/wwwroot/conf/fonts/ARLRDBD.TTF',
        'pixel' => 20,
        'line' => 5,
        'snow' => 5,
        'size' => 25,
        'length' =>4,
        'width' => '120',
        'height' => '40',
    ];

    public function __construct($config)
    {
        $this->_config = array_merge($this->_config,$config);
        parent::__construct($this->_config);
    }

    public function getCaptcha()
    {

        $white = imagecolorallocate($this->_image, 255, 255, 255);
        //填充矩形
        imagefilledrectangle($this->_image, 0, 0, $this->_width, $this->_height, $white);
        $str = $this->_generateStr($this->_length);

        if (false === $str) {
            return false;
        }
        $fontfile = $this->_fontfile;
        $size = $this->_size;
        //绘制验证码
        for ($i = 0; $i < $this->_length; $i++) {

                //正立的字体
                $angle = mt_rand(-30, 30);
                $x = ceil($this->_width / $this->_length) * $i + mt_rand(5, 10);
                $y = ceil($this->_height / 1.5);
                $color = $this->_getRandColor();
                $text = $this->_generateStr($this->_length);
                $str = $text{$i};
                imagettftext($this->_image, $size, $angle, $x, $y, $color, $fontfile, $str);

        }

        if ($this->_snow) {
            $this->_getSnow();
        }
        if ($this->_pixel) {
            $this->_getPixel();
        }
        if ($this->_line) {
            $this->_getLine();
        }

        ob_start();
        imagepng($this->_image);
        $data = ob_get_clean();
        // imagepng($this->_image);
        // imagepng($this->_image,$this->_image_save_path);
        imagedestroy($this->_image);
        return $data;
    }

    /**
     * 产生验证码字符
     *
     * @param int $length
     * @return string
     */

    private function _generateStr($length = 4)
    {
        if ($length < 1 || $length > 30) {
            return false;
        }

        $chars = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'k', 'm', 'n', 'p', 'x', 'y', 'z',
            'A','B','C','D','E','F','G','H','K','M','N','P','Q','R','S','T',
             1, 2, 3, 4, 5, 6, 7, 8, 9];
        $str = join('', array_rand(array_flip($chars), $length));
        return $str;
    }

    public function captchaValue(){

    }

    public function getHtml()
    {
        // TODO: Implement getHtml() method.

    }

    public function judgeCaptcha($captcha_source,$captcha)
    {
       // TODO: Implement judgeCaptcha() method.


    }

}