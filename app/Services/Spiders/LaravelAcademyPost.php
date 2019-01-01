<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/12/29
 * Time: 15:25
 */

namespace App\Services\Spiders;

use App\Contracts\Spider;
use App\Services\T;
use Goutte\Client;
use GuzzleHttp\Client as GzClient;

class LaravelAcademyPost implements Spider
{
    public function run($url, $callback)
    {
        $response = T::crawler($url);
        $title = $response->filter("#main > article > header > h1")->text();
        $html = $response->filter("#main > article > div")->html();
        return $callback($title, T::markdown($html));
    }
}