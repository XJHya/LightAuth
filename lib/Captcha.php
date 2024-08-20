<?php
namespace Lib;

class Captcha {
    public function LoadCaptcha() {
        session_start();
        $width = 100;
        $height = 30;
        $bgColor = [255, 255, 255, 30];
        $image = imagecreatetruecolor($width, $height);
        $backgroundColor = imagecolorallocatealpha($image, ...$bgColor);
        imagefill($image, 0, 0, $backgroundColor);
        $data = "asdfghjklqwertyuipzxcvbnm123456789";
        $code = "";
        $fontSize = 8;
        $charCount = 4;

        for ($i = 0; $i < $charCount; $i++) {
            $fontColor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
            $char = $data[rand(0, strlen($data) - 1)];
            $code .= $char;
            $x = ($i * $width / $charCount) + rand(0, 9);
            $y = rand(5, 10);
            imagestring($image, $fontSize, $x, $y, $char, $fontColor);
        }

        $_SESSION['captcha_code'] = $code;
        $_SESSION['captcha_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['captcha_device'] = $this->getDeviceInfo();

        $pointCount = 200;
        for ($i = 0; $i < $pointCount; $i++) {
            $pointColor = imagecolorallocate($image, rand(100, 220), rand(100, 220), rand(100, 220));
            imagesetpixel($image, rand(0, $width - 1), rand(1, $height - 1), $pointColor);
        }
        $lineCount = 3;
        for ($i = 0; $i < $lineCount; $i++) {
            $lineColor = imagecolorallocate($image, rand(50, 150), rand(50, 150), rand(50, 150));
            imageline($image, rand(1, $width - 1), rand(1, $height - 1), rand(1, $width - 1), rand(1, $height - 1), $lineColor);
        }

        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }

    public function VerifyCaptcha($captcha_code) {
        session_start();
        $storedCode = $_SESSION['captcha_code'] ?? '';
        $storedIp = $_SESSION['captcha_ip'] ?? '';
        $storedDevice = $_SESSION['captcha_device'] ?? '';

        if ($storedIp !== $_SERVER['REMOTE_ADDR'] || $storedDevice !== $this->getDeviceInfo()) {
            // 删除验证成功的信息
            unset($_SESSION['captcha_code']);
            unset($_SESSION['captcha_ip']);
            unset($_SESSION['captcha_device']);
            return false;
        }

        return $captcha_code === $storedCode;
    }

    private function getDeviceInfo() {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    }
}
?>
