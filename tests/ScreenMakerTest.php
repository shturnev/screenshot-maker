<?php
/**
 * User: sht.
 * Date: 22.01.2018
 * Time: 0:21
 */

namespace tests;

use classes\ScreenMaker;
use PHPUnit\Framework\TestCase;

class ScreenMakerTest extends TestCase
{

    /**
     * Должен вернуть массив с url картинки
     */
    public function testGet_img_dir()
    {
        $arr = ['url' => 'https://work-timer.pro/'];
        $res = (new ScreenMaker())->get_screen_by_url($arr);
        $this->assertTrue(is_array($res));
    }

}
