<?php
namespace Libraries\Captcha;

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
    protected $_image ;
    private $_randArray = [];

    public function __construct($config = [])
    {
        $this->_config = array_merge($this->_config,$config);
        parent::__construct($this->_config);
        $this->initProperty();
        $this->_image =  imagecreatetruecolor($this->_width, $this->_height);
    }

    public function initProperty(){

        $this->_randArray = $this->_getRandArray();
        if (count($this->_randArray) > $this->_length && empty($this->_randArray)) {
            return false;
        }
    }

    public function getCaptcha()
    {

       $white = imagecolorallocate($this->_image, 255, 255, 255);
       // $white = imagecolorallocate(imagecreatetruecolor($this->_width, $this->_height), 255, 255, 255);
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
              //  log_message('info',json_encode($fontfile));
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
        $html = <<<EOD
<div id ="container" class="container">
    <style>
        .demo2 {
            width:20px;
            height:20px;
            border-radius:20px ;
            background:green;
            display:block;
            position: relative;
        }
        .demo2:before, .demo2::after {
            content:"";
            height:14px;
            width:3px;
            border-radius: 5px;
            display:block;
            background:white;
            position: absolute;
            top:3px;/*40-6=34*/
            left:10px;/*make the two rects in the middle of the cycle */
            transform:rotate(45deg);
            -ms-transform:rotate(45deg);
        }
        .demo2::before {
            height:7.5px;
            transform: rotate(-45deg);
            -ms-transform:rotate(-45deg);
            position: absolute;
            top:9px;/*40-18=12  */
            left:4px;
        }
        .container {
            position: relative;
        }
        .demo2 {
            position:absolute;
        }
         #flash_Button{
            position: absolute;
            right:0;
            width:70px;
            height: 24px;
            background-color:#f00;
            border-radius: 10px;
            color:#fff;
            text-align: center;
            cursor:pointer;
        }
    </style>

   <div class="tip">
   请点击下图所有倒立的汉字
   <span id='flash_Button'onclick="flashOnClick(event)">刷新</span>        
   </div>
    <img id='img_captcha' src="/account/request_captcha" onclick="mapOnClick(event)">
    
    <script>var bucket = [];
    
      var cap_name = "verify";
      function flashOnClick(){
        var container = document.getElementsByClassName('container')[0];
        var spans = container.getElementsByClassName('demo2');
        var length = spans.length;
        for (var i = length -1; i >= 0; i--){
            spans[i].remove();
        }
        bucket = [];
        delCookie(cap_name);
        var img = document.getElementById('img_captcha');
        var newImgSrc = '/account/request_captcha?t=' + (new Date().getTime());
        img.setAttribute('src',newImgSrc);
    }
    function mapOnClick(e){
        e = e || window.event;
        var imgId = document.getElementById('img_captcha');
         var con = document.getElementById('container');
        // var currentWidth = imgId.naturalWidth;
        // var currentHeight = imgId.naturalHeight;
         var currentWidth = imgId.width
         var currentHeight = imgId.height;
        // var offsetX = e.pageX - offset(imgId).left;
        // var offsetY = e.pageY - offset(imgId).top;
          var offsetX = e.pageX - offset(con).left;
          var offsetY = e.pageY - offset(con).top;
        var vlue = exchange(offsetX,currentWidth,{$length});
        vlue =parseInt(vlue);
        bucket.push(vlue);
        var span  =  createElement(vlue);
        span.style.top = offsetY -6+ 'px';
        span.style.left = offsetX-6 + 'px';
        document.getElementsByClassName('container')[0].appendChild(span);
    }

    function createElement(vlue) {
        var span = document.createElement('span');
        span.onclick = function (ev) {
            this.remove();
            var  index = bucket.indexOf(vlue);
            if (index > -1) {
                bucket.splice(index, 1);
            }
            setCookie(cap_name,bucket.join('-'));
            span.setAttribute('class', 'demo2');
        }
        bucket = unique3(bucket).sort();
        setCookie(cap_name,bucket.join('-'));
        span.setAttribute('class', 'demo2');
        return span;
    }

    function setCookie(name,value) {
        document.cookie = name + '=' + escape(value);
    }
    function delCookie(name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getCookie(name);
        if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    }
    function getCookie(name)
    {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
        else
        return null;
    }

    function exchange(x,width,length){
        return length * (x/width);
    }
    function unique3(array){
        var n = [array[0]];
        for(var i = 1; i < array.length; i++) {
            if (array.indexOf(array[i]) == i) n.push(array[i]);
        }
        return n;
    }
    function offset(target) {
        var top = 0,
            left = 0

        while(target.offsetParent) {
            top += target.offsetTop
            left += target.offsetLeft
            target = target.offsetParent
        }

        return {
            top: top,
            left: left,
        }
     
      
    }

    </script>

</div>
</div>
EOD;

 return $html;

  }

}