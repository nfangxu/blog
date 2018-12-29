<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/12/29
 * Time: 15:25
 */

namespace App\Services\Spiders;

use App\Contracts\LaravelChinaSpider;
use App\Services\T;
use Goutte\Client;
use GuzzleHttp\Client as GzClient;

class LaravelAcademyPost implements LaravelChinaSpider
{
    public function run($url, $callback)
    {
        $client = new Client();
        $client->setClient(new GzClient());

        $response = $client->request("get", $url);
        $title = $response->filter("#main > article > header > h1")->text();
        $html = $response->filter("#main > article > div")->html();
        return $callback($title, T::markdown($html));
    }

    public function tag()
    {
        return [
            "Telescope",
            "laravel",
            "扩展包"
        ];
    }
}