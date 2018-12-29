<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query()
            ->select(["id", "title"])
            ->where("status", 1)
            ->orderBy("updated_at", "desc")
            ->simplePaginate(50);
        return view("article.index", compact("articles"));
    }

    public function detail(Request $request, $id)
    {
        $article = Article::query()->where("status", 1)->findOrFail($id);

        // 推荐文章
        $tags = Tag::with("articles")->whereIn("id", $article->tags->pluck('id'))->get();
        $articles = collect();
        foreach ($tags as $tag) {
            $articles = $articles->concat($tag->articles);
        }

        // 视图
        return view("article.detail", [
            "article" => $article,
            "articles" => $articles->whereNotIn("id", $id),
        ]);
    }

    public function indexByTag(Request $request, $id)
    {
        $tags = Tag::with("articles")->findOrFail($id);
        $articles = $tags->articles;
        return view("article.index", compact("articles"));
    }
}
