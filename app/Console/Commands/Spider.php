<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Tag;
use Goutte\Client;
use GuzzleHttp\Client as GzClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Spider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = "https://laravel-china.org/docs/php-design-patterns/2018";
        $client = new Client();
        $client->setClient(new GzClient());
        $tag = Tag::query()->firstOrCreate(["name" => "设计模式"])->id;

        $client->request("get", $url)->filter("ol.chapter-container > li > a")
            ->reduce(function ($node) use ($client, $tag) {
                $link = $node->attr("href");
                $title = trim(str_replace("已完成", "", $node->text()));
                $client->request("get", $link)
                    ->filterXPath("html/body/div[4]/div[1]/div/div[1]/div[1]/div/div[2]")
                    ->reduce(function ($node) use ($title, $tag) {
                        $html = $node->html();
                        $this->info($title);
                        $text = self::transHtmlToMarkdown($html);
                        $id = Article::query()->insertGetId([
                            "title" => $title,
                            "content" => $text,
                            "status" => 1,
                            "created_at" => now(),
                            "updated_at" => now(),
                        ]);

                        DB::table("article_tag")->insert([
                            "article_id" => $id,
                            "tag_id" => $tag,
                        ]);
                    });
            });
        return true;
    }

    private static function transHtmlToMarkdown($html)
    {
        $markdown = preg_replace_callback_array([
            "/\n+/" => function ($r) {
                return "\n";
            },
            "/<p>(?<content>[\s\S]*?)<\/p>/" => function ($r) {
                return $r["content"];
            },
            "/<code[\s\S]*?>(?<content>[\s\S]*?)<\/code>/" => function ($r) {
                $code = $r["content"];
                return "\n```\n$code\n```\n\n";
            },
            "/<div(?<content>[\s\S]*?)<\/div>/" => function ($r) {
                return "";
            },
            "/<pre>(?<content>[\s\S]*?)<\/pre>/" => function ($r) {
                return $r["content"];
            },
            "/<ul>(?<content>[\s\S]*?)<\/ul>/" => function ($r) {
                return $r["content"];
            },
            "/<strong>(?<content>[\s\S]*?)<\/strong>/" => function ($r) {
                return "**" . $r["content"] . "**";
            },
            "/<li>(?<content>[\s\S]*?)<\/li>/" => function ($r) {
                return "- " . $r["content"];
            },
            "/<a href=\"(?<link>[\s\S]*?)\">(?<text>[\s\S]*?)<\/a>/" => function ($r) {
                return "[{$r['text']}]({$r['link']})";
            },
            "/<h(?<times>\d)>(?<title>[\s\S]*?)<\/h\d>/" => function ($r) {
                return (str_repeat("#", $r["times"]) . " " . $r["title"]);
            },
            "/<img[\s\S]*?src=\"(?<url>[\s\S]*?)\"[\s\S]*?>/" => function ($r) {
                return "![图片]({$r['url']})";
            },
        ], $html);

        $markdown = str_replace("&lt;", "<", $markdown);
        $markdown = str_replace("&gt;", ">", $markdown);
        return trim($markdown);
    }
}
