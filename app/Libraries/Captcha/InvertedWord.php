<?php
namespace App\Libraries\Captcha;

class InvertedWord  extends AbstractCaptcha implements Captcha
{

    private $_config = [
        'fontfile' => 'D:\phpStudy\PHPTutorial\WWW\captcha\fonts\STXINGKA.TTF',
        'pixel' => 30,
        'line' => 10,
        'snow' => 10,
        'size' => 30,
        'length' => 6,
        'width' => '400',
        'height' => '80',
        'inverted_num'=>3,
    ];
    private $_htmlPath = __DIR__.'/InvertedWord.html';
    private $_appHtmlPath = __DIR__.'views/InvertedWord.html';

    private $_invertedWord =[
        'background_color' =>[255,255,255],
        'html_path' => __DIR__.'views/InvertedWord.html'

    ];

    private $_randArray = [];

    public function __construct($config = [])
    {
        $this->_config = array_merge($this->_config,$config);
        parent::__construct($this->_config);
        $this->initProperty();

    }

    public function initProperty(){

        $this->_randArray = $this->_getRandArray();
        if (count($this->_randArray) > $this->_length && empty($this->_randArray)) {
            return false;
        }
    }

    public function getCaptcha()
    {

        $white = imagecolorallocate($this->_image, $this->_invertedWord['background_color'][0],  $this->_invertedWord['background_color'][1], $this->_invertedWord['background_color'][2]);
        //填充矩形
        imagefilledrectangle($this->_image, 0, 0, $this->_width, $this->_height, $white);

        $fontfile = $this->_fontfile;
        $size = $this->_size;
        //绘制验证码
        for ($i = 0; $i < $this->_length; $i++) {

            if (in_array($i, $this->_randArray)) {
                //倒立的字体
                //$angle = 180;
                $angle = mt_rand(170,190);
                $x = ceil($this->_width / $this->_length) * $i + mt_rand(5, 10) + $size;
                $y = ceil($this->_height / 1.5) - mt_rand(3, 6) - $size;
                $color = $this->_getRandColor();
                $text = $this->_generateChinaese();
                // log_message('info',json_encode($fontfile));
                imagettftext($this->_image, $size, $angle, $x, $y, $color, $fontfile, $text);
            } else {
                //正立的字体
                $angle = mt_rand(-30, 30);
                $x = ceil($this->_width / $this->_length) * $i + mt_rand(5, 10);
                $y = ceil($this->_height / 1.5);
                $color = $this->_getRandColor();
                $text = $this->_generateChinaese();
                imagettftext($this->_image, $size, $angle, $x, $y, $color, $fontfile, $text);
            }
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
       // header('content-type:image/png');
        ob_start();
        imagepng($this->_image);
        $data = ob_get_clean();
       // imagepng($this->_image);
       // imagepng($this->_image,$this->_image_save_path);
        imagedestroy($this->_image);
        return $data;
    }



    /**生成随机的数组
     * @return array|mixed
     */
    private function _getRandArray()
    {
        $arr = range(0, $this->_length - 1);
        $arr = array_rand($arr, mt_rand(1, $this->_config['inverted_num']));
        if (!is_array($arr)) {
            $arr = [$arr];
        }
        return $arr;
    }

    /**生成随机汉字
     * @param int $length
     *
     * @return string
     */
    private function _generateChinaese($length = 4)
    {
        $char = chr(mt_rand(0xB0, 0xD0)) . chr(mt_rand(0xA1, 0xF0));
        $text = iconv('GB2312', 'UTF-8', $char);
        return $text;
    }


    public function captchaValue(){

        $str = implode("-", $this->_randArray);

        return $str;

    }

    // 验证验证码
    public function judgeCaptcha($captcha_source,$captcha)
    {

          if (empty($captcha_source) || empty($captcha)) {

          return false;

          }

          if($captcha != $captcha_source){

          return false;

          }
          return true;
    }

    public function getHtml()
    {
       // TODO: Implement getHtml() method.

        $length = $this->_length;
       // $image_path = $this->_image_save_path;
       $htmlPath = $this->getHtmlPath();
        if(!empty($htmlPath)){
            $htmlContent = file_get_contents($htmlPath);
            $pattern ='/\{\$length\}/';
            $htmlContent =  preg_replace($pattern, $length, $htmlContent);

            return $htmlContent;
        }else{

           return '';

        }
  }

  public function getHtmlPath()
  {

     if(!empty($this->_invertedWord['html_path']) && file_exists($this->_invertedWord['html_path'])){

         return $this->_invertedWord['html_path'];
     }

      if(file_exists($this->_appHtmlPath))
      {
         return $this->_appHtmlPath;
      }

      if(file_exists($this->_htmlPath)){
          return $this->_htmlPath;
      }

     return '';

  }


}