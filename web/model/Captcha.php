<?php
/**
 * Captcha
 * @version 1.0
 * @category projectX
 * @package ProjectX
 */
class Captcha
{
    public function __construct()
    {
        //TODO: Control when we first use session_start()
        //session_start();

        // General settings
        // captcha width
        $captcha_w = 150;
        // captcha height
        $captcha_h = 50;
        // minimum font size; each operation element changes size
        $min_font_size = 12;
        // maximum font size
        $max_font_size = 18;
        // rotation angle
        $angle = 20;
        // background grid size
        $bg_size = 13;
        // path to font - needed to display the operation elements
        $font_path = dirname(__FILE__) . '/../content/fonts/courbd.ttf';
        // array of possible operators
        $operators = array('+', '-', '*');
        // first number random value; keep it lower than $second_num
        $first_num = rand(1, 5);
        // second number random value
        $second_num = rand(6, 11);

        shuffle($operators);
        $expression = $second_num . $operators[0] . $first_num;

        //operation result is stored in $session_var
        eval("\$session_var=" . $second_num . $operators[0] . $first_num . ";");

        //save the operation result in session to make verifications
        $_SESSION['security_number'] = $session_var;

        //start the captcha image
        $img = imagecreate($captcha_w, $captcha_h);

        //Some colors. Text is $black, background is $white, grid is $grey
        $black = imagecolorallocate($img, 0, 0, 0);
        $white = imagecolorallocate($img, 255, 255, 255);
        $grey = imagecolorallocate($img, 215, 215, 215);

        //make the background white
        imagefill($img, 0, 0, $white);

        // the background grid lines - vertical lines
        for ($t = $bg_size; $t < $captcha_w; $t += $bg_size) {
            imageline($img, $t, 0, $t, $captcha_h, $grey);
        }
        // background grid - horizontal lines
        for ($t = $bg_size; $t < $captcha_h; $t += $bg_size) {
            imageline($img, 0, $t, $captcha_w, $t, $grey);
        }

        /*
         this determinates the available space for each operation element
         it's used to position each element on the image so that they don't overlap
         */
        $item_space = $captcha_w / 3;

        //first number
        imagettftext($img, rand($min_font_size, $max_font_size), rand(-$angle, $angle), rand(10, $item_space - 20), rand(25, $captcha_h - 25), $black, $font_path, $second_num);

        //operator
        imagettftext($img, rand($min_font_size, $max_font_size), rand(-$angle, $angle), rand($item_space, 2 * $item_space - 20), rand(25, $captcha_h - 25), $black, $font_path, $operators[0]);

        //second number
        imagettftext($img, rand($min_font_size, $max_font_size), rand(-$angle, $angle), rand(2 * $item_space, 3 * $item_space - 20), rand(25, $captcha_h - 25), $black, $font_path, $first_num);

        //save image
        imagejpeg($img, 'secure.jpg');
    }

}
