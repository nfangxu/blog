<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/12/29
 * Time: 12:43
 */

namespace App\Services\Spiders;

use App\Contracts\Spider;
use App\Services\T;
use Goutte\Client;
use GuzzleHttp\Client as GzClient;

/**
 * 抓取 laravel-china 的 topic 内容
 * Class LaravelChinaTopic
 * @package App\Services\Spiders
 */
class LaravelChinaTopic implements Spider
{
    public function run($url, $callback)
    {
        $response = T::crawler($url);
        $title = $response->filterXPath("html/body/div[2]/div[1]/div[1]/div[1]/div[1]/div/h1/div[1]/span[2]")->text();
        $html = $response->filterXPath("html/body/div[2]/div[1]/div[1]/div[1]/div[1]/div/div[2]")->html();
        return $callback($title, T::markdown($html));
    }
}
