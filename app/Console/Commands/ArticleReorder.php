<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class ArticleReorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:reorder {start} {end}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'articles reorder';

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
        $start = $this->argument("start");
        $end = $this->argument("end");

        $articles = Article::query()
            ->whereBetween("id", [$start, $end])
            ->orderBy("id", "desc")
            ->get();

        foreach ($articles as $article) {
            $article->touch();
            $this->info($article->id);
            sleep(1);
        }
        return true;
    }
}
