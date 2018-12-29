<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/12/29
 * Time: 14:29
 */

namespace App\Contracts;


interface LaravelChinaSpider
{
    /**
     * @param $url
     * @param  $callback ($title, $text)
     * @return mixed
     */
    public function run($url, $callback);

    /**
     * @return array
     */
    public function tag();
}