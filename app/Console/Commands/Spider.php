<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Spider extends Command
{
    protected $signature = 'spider {url} {tags*} {--status=2}';

    protected $description = 'Command description';

    public function handle()
    {
        $url = $this->argument("url");

        $spiderName = $this->choice("SpiderServices", [
            "LaravelChinaTopic",
            "LaravelAcademyPost",
            "LaravelChinaDocs",
        ], 0);

        $status = $this->option("status");

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
        return $spider->run($url, function ($title, $text) use ($tags, $status) {
            $id = Article::query()->insertGetId([
                "title" => $title,
                "content" => $text,
                "status" => $status,
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
