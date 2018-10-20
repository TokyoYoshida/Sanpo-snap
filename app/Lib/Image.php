<?php
/**
 * Created by PhpStorm.
 * User: tokyomac
 * Date: 2018/10/17
 * Time: 4:22
 */

namespace App\Lib;


class Image
{
    /**
     * remove image property and save
     *
     * @param $load_filename
     * @param $save_filename
     */
    static public function stripImage($load_filename, $save_filename) {
        $img = new \Imagick($load_filename);
        $img->stripImage();
        $img->writeImage($save_filename);
    }
}
