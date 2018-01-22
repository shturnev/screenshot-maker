<?php
/**
 * User: sht.
 * Date: 22.01.2018
 * Time: 0:01
 */

namespace classes;

use Screen\Capture;
use Screen\Exceptions\PhantomJsException;

class ScreenMaker
{


    /**
     * Создать screen из url
     * @param $array
     * @return array
     * @throws PhantomJsException
     * @throws \Exception
     */
    public function get_screen_by_url($array)
    {
        if (!filter_var($array['url'], FILTER_VALIDATE_URL)) {
            throw new \Exception('не корректный url');
        }

        $filename = md5($array['url']) . ".jpg";
        $w = (is_numeric($array['w'])) ? $array['w'] : 640;
        $h = (is_numeric($array['h'])) ? $array['h'] : 480;

        $screenCapture = new Capture($array['url']);
        $screenCapture->setWidth($w);
        $screenCapture->setHeight($h);
        $screenCapture->setImageType('jpg');
        $screenCapture->save($this->get_img_dir() . $filename);

        return [
            'name' => parse_url($array['url'])['host'],
            'url'  => $this->clear_url('/FILES/'.$filename),
            'filename' => $filename
        ];


    }


    //helpers
    public function get_img_dir()
    {
        $DS = DIRECTORY_SEPARATOR;
        $ROOT = strstr(__DIR__, 'classes', true);
        if (!is_dir($ROOT . 'FILES')) {
            mkdir($ROOT . 'FILES', 0777, true);
        }
        return $ROOT . 'FILES' . $DS;
    }

    public function clear_url($dir = null){

        $isHttps  = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
        $protocol = ($isHttps)? "https" : "http";

        return $protocol."://". $_SERVER["HTTP_HOST"].$dir;
    }


}