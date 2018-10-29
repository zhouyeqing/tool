<?php
/**
 * Created by PhpStorm.
 * User: 周叶青
 * Date: 2018/10/29 0029
 * Time: 19:08
 */
class Vcode {
    private $height;             //验证码图片高度
    private $width;              //验证码图片宽度
    private $codeNum;            //验证码字符个数
    private $disturbColorNum;    //干扰元素数量
    private $checkCode;          //验证码字符
    private $image;              //验证码资源
    function __construct ($width=80, $height=20, $codeNum=4) {
        $this->height = $height;
        $this->width = $width;
        $this->codeNum = $codeNum;
        $number = floor($width*$height/15);
        if ($number > 240-$codeNum) {
            $this->disturbColorNum = 240-$codeNum;
        } else {
            $this->disturbColorNum = $number;
        }
        $this->checkCode = $this->createCheckCode();
    }
    function __toString () {
        $_SESSION['code'] = strtoupper($this->checkCode);
        $this->outImg();
        return '';
    }
    private function outImg () {
        $this->getCreateImage();
        $this->setDisturbColor();
        $this->outputText();
        $this->outputImage();
    }
    private function getCreateImage () {
        $this->image = imagecreatetruecolor($this->width,$this->height);
        $backColor = imagecolorallocate($this->image,rand(225,255),rand(225,255),rand(225,255));
        @imagefill($this->image,0,0,$backColor);
        $border = imagecolorallocate($this->image,0,0,0);
        imagerectangle($this->image,0,0,$this->width-1,$this->height-1,$border);
    }
    private function createCheckCode () {
        $code = "3456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $ascii = '';
        for ($i = 0;$i < $this->codeNum;$i++) {
            $char = $code[rand(0,strlen($code)-1)];
            $ascii .= $char;
        }
        return $ascii;
    }
    private function setDisturbColor () {
        for ($i = 0; $i < $this->disturbColorNum; $i++) {
            $color = imagecolorallocate($this->image,rand(0,255),rand(0,255),rand(0,255));
            imagesetpixel($this->image,rand(1,$this->width-2),rand(1,$this->height-2),$color);
        }
        for ($i = 0; $i < 10; $i++) {
            $color = imagecolorallocate($this->image,rand(0,255),rand(0,255),rand(0,255));
            imagearc($this->image,rand(-10,$this->width),rand(-10,$this->height),rand(30,300),rand(20,200),55,44,$color);
        }
    }
    private function outputText () {
        for ($i = 0; $i < $this->codeNum; $i++) {
            $color = imagecolorallocate($this->image,rand(0,128),rand(0,128),rand(0,128));
            $fontSize = rand(3,5);
            $x = floor(($this->width/$this->codeNum)*$i + 3);
            $y = rand(0,$this->height - imagefontheight($fontSize));
            imagechar($this->image,$fontSize,$x,$y, $this->checkCode[$i], $color);
        }
    }
    private function outputImage () {
        if (function_exists("imagepng")) {
            header('Content-type: image/png');
            imagepng($this->image);
        } elseif (function_exists("imagegif")) {
            header('Content-type: image/gif');
            imagegif($this->image);
        } elseif (function_exists("imagejpeg")) {
            header('Content-type: image/jpeg');
            imagejpeg($this->image, "", 0.5);
        } elseif (function_exists("imagewbmp")) {
            header('Content-type: image/vnd.wap.wbmp');
            imagewbmp($this->image);
        } else {
            die('在PHP服务器中，不支持图像');
        }
    }
    function __destruct () {
        imagedestroy($this->image);
    }
}