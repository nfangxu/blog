<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/12/29
 * Time: 12:39
 */

namespace App\Services;

use League\HTMLToMarkdown\HtmlConverter;
use Goutte\Client;
use GuzzleHttp\Client as GzClient;

class T
{
    public static function markdown($html)
    {
        return (new HtmlConverter())->convert($html);
    }

    public static function crawler($url)
    {
        return (new Client())->setClient(new GzClient())->request("get", $url);
    }
}