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
            ->get();
        return view("article.index", compact("articles"));
    }

    public function detail(Request $request, $id)
    {
        $article = Article::query()->where("status", 1)->findOrFail($id);
        $tags = Tag::with("articles")->whereIn("id", $article->tags->pluck('id'))->get();
        $articles = collect();
        foreach ($tags as $tag) {
            $articles = $articles->concat($tag->articles);
        }
        return view("article.detail", [
            "article" => $article,
            "articles" => $articles->whereNotIn("id", $id),
        ]);
    }

    public function indexByTag(Request $request, $id)
    {
        $tags = Tag::with("articles")->find($id);
        $articles = $tags->articles;
        return view("article.index", compact("articles"));
    }
}
