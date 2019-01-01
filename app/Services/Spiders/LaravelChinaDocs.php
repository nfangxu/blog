<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/12/29
 * Time: 12:38
 */

namespace App\Services\Spiders;

use App\Contracts\Spider;
use App\Services\T;
use Goutte\Client;
use GuzzleHttp\Client as GzClient;

/**
 * 抓取 laravel-china 的文档内容
 * Class LaravelChinaDocs
 * @package App\Services\Spiders
 */
class LaravelChinaDocs implements Spider
{
    public function run($url, $callback)
    {
        $client = new Client();
        $client->setClient(new GzClient());

        $client->request("get", $url)->filter("ol.chapter-container > li > a")
            ->reduce(function ($node) use ($client, $callback) {
                $link = $node->attr("href");
                $title = trim(str_replace("已完成", "", $node->text()));
                $client->request("get", $link)
                    ->filterXPath("html/body/div[4]/div[1]/div/div[1]/div[1]/div/div[2]")
                    ->reduce(function ($node) use ($title, $callback) {
                        $html = $node->html();
                        $text = T::markdown($html);
                        return $callback($title, $text);
                    });
            });
        return true;
    }
}