<?php
namespace Lib;

class Captcha{
    public function LoadCaptcha(){
        session_start();
        $code = "";
        $image = imagecreatetruecolor(100, 30);
        $color = imagecolorallocatealpha($image, 255, 255, 255, 30);
        imagefill($image, 0, 0, $color);
        for ($i = 0; $i < 4; $i++) {
            $fontSize = 8;
            $fontColor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
            $data = "asdfghjklqwertyuipzxcvbnm123456789";
            $fontContent = substr($data, rand(0, strlen($data) - 1), 1);
            $code .= $fontContent;
            $x = ($i * 100 / 4) + rand(0, 9);
            $y = rand(5, 10);
            imagestring($image, $fontSize, $x, $y, $fontContent, $fontColor);
        }
        $_SESSION['code'] = $code;
        for ($i = 0; $i < 200; $i++) {
            $pointColor = imagecolorallocate($image, rand(100, 220), rand(100, 220), rand(100, 220));
            imagesetpixel($image, rand(0, 98), rand(1, 29), $pointColor);
        }
        for ($i = 0; $i < 3; $i++) {
            $lineColor = imagecolorallocate($image, rand(50, 150), rand(50, 150), rand(50, 150));
            imageline($image, rand(1, 99), rand(1, 29), rand(1, 99), rand(1, 29), $lineColor);
        }
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}
?>
