<?php

namespace Libraries\Captcha;

abstract class AbstractCaptcha
{

    protected $_fontfile = ''; //字体文件
    protected $_width = 120;   //画布宽度
    protected $_height = 40;  //画布高度
    protected $_length = 4;  //验证码长度
    protected $_size = 30;    //字体大小
    protected $_image = null;
    protected $_snow = 0;  //雪花个数
    protected $_pixel = 0;  //像素个数
    protected $_line = 0;  // 线段个数
    protected $_image_save_path = './images/'; //保存路径

    public function __construct($config)
    {
        $this->VerifyAttribute($config);
    }

    protected function VerifyAttribute($config)
    {
        if (is_array($config) && count($config) > 0) {
            //检测字体文件是否存在并且可读
            if (isset($config['fontfile']) && is_file($config['fontfile']) && is_readable($config['fontfile'])) {

                $this->_fontfile = $config['fontfile'];
            } else {
                return false;
            }

            if (isset($config['width']) && $config['width'] > 0) {
                $this->_width = (int)$config['width'];
            }

            if (isset($config['height']) && $config['height'] > 0) {
                $this->_height = (int)$config['height'];
            }
            if (isset($config['length']) && $config['length'] > 0) {
                $this->_length = (int)$config['length'];
            }
            if (isset($config['size']) && $config['size'] > 0) {
                $this->_size = (int)$config['size'];
            }
            //设置干扰元素
            if (isset($config['snow']) && $config['snow'] > 0) {
                $this->_snow = (int)$config['snow'];
            }

            if (isset($config['pixel']) && $config['pixel'] > 0) {
                $this->_pixel = (int)$config['pixel'];
            }
            if (isset($config['line']) && $config['line'] > 0) {
                $this->_line = (int)$config['line'];
            }

            if (isset($config['image_path'])) {
                $this->_image_save_path = $config['image_path'];
            }


            $this->_image_save_path = $this->_image_save_path . uniqid() . '.png';
            $this->_image = imagecreatetruecolor($this->_width, $this->_height);
           // return $this->_image;
        } else {
            return false;
        }
    }

    /**
     * 生成随机颜色
     *
     * @return int
     */
    protected function _getRandColor()
    {

        return imagecolorallocate($this->_image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    }

    /**
     * 绘制雪花
     */

    protected function _getSnow()
    {
        for ($i = 1; $i <= $this->_snow; $i++) {

            imagestring($this->_image, mt_rand(1, 5), mt_rand(0, $this->_width), mt_rand(0, $this->_height), '*', $this->_getRandColor());
        }
    }

    /**
     * 绘制点
     */
    protected function _getPixel()
    {
        for ($i = 1; $i <= $this->_pixel; $i++) {
            imagesetpixel($this->_image, mt_rand(0, $this->_width), mt_rand(0, $this->_height), $this->_getRandColor());
        }
    }

    /**
     * 绘制线段
     */
    protected function _getLine()
    {

        for ($i = 1; $i <= $this->_line; $i++) {
            imageline(
                $this->_image,
                mt_rand(0, $this->_width),
                mt_rand(0, $this->_height),
                mt_rand(0, $this->_width),
                mt_rand(0, $this->_height),
                $this->_getRandColor()
            );
        }
    }

    public abstract function getHtml();


}