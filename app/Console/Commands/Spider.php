<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Tag;
use App\Services\Spiders\LaravelChinaTopic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Spider extends Command
{
    protected $signature = 'spider {url}';

    protected $description = 'Command description';

    public function handle(LaravelChinaTopic $spider)
    {
        $url = $this->argument("url");
        $tags = [];
        foreach ($spider->tag() as $tag) {
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
            DB::table("article_tag")->insert($articleTags);
        });
    }
}
