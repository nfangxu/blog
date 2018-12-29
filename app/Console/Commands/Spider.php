<?php

namespace App\Console\Commands;

use App\Contracts\LaravelChinaSpider;
use App\Models\Article;
use App\Models\Tag;
use App\Services\Spiders\LaravelChinaTopic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Spider extends Command
{
    protected $signature = 'spider {url} {tags*}';

    protected $description = 'Command description';

    public function handle()
    {
        $url = $this->argument("url");

        $spiderName = $this->choice("SpiderServices", [
            "LaravelAcademyPost",
            "LaravelChinaDocs",
            "LaravelChinaTopic",
        ]);

        $class = "App\\Services\\Spiders\\" . $spiderName;
        if (class_exists($class)) {
            $spider = new $class();
        } else {
            $this->error("Spider not exists !");
        }

        $tags = [];
        foreach ($this->argument("tags") as $tag) {
            $tags[] = Tag::query()->firstOrCreate([
                "name" => $tag
            ])->id;
        }
        return $spider->run($url, function ($title, $text) use ($tags) {
            $id = Article::query()->insertGetId([
                "title" => $title,
                "content" => $text,
                "status" => 2,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
            $articleTags = [];
            foreach ($tags as $tag) {
                $articleTags[] = [
                    "article_id" => $id,
                    "tag_id" => $tag,
                ];
            }
            if ($articleTags)
                DB::table("article_tag")->insert($articleTags);
        });
    }
}
