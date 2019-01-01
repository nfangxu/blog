<?php


namespace App\Contracts;


interface Spider
{
    /**
     * @param $url
     * @param  $callback ($title, $text)
     * @return mixed
     */
    public function run($url, $callback);
}