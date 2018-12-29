<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/12/29
 * Time: 11:15
 */

namespace App\Admin;

use Encore\Admin\Controllers\Dashboard as Base;
use Illuminate\Support\Facades\Redis;

class Dashboard extends Base
{
    public static function visits()
    {
        $visits = [
            "article" => [
                "total" => self::t("articles_visits_total"),
                "day" => self::t("articles_visits_day_total"),
                "week" => self::t("articles_visits_week_total"),
                "month" => self::t("articles_visits_month_total"),
                "year" => self::t("articles_visits_year_total"),
            ],
            "tag" => [
                "total" => self::t("tags_visits_total"),
                "day" => self::t("tags_visits_day_total"),
                "week" => self::t("tags_visits_week_total"),
                "month" => self::t("tags_visits_month_total"),
                "year" => self::t("tags_visits_year_total"),
            ],
        ];
        return view("admin.visit", compact("visits"));
    }

    private static function t($key)
    {
        return (int)Redis::connection("laravel-visits")
            ->get("visits:" . $key);
    }
}