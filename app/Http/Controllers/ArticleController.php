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
        $article = Article::query()->findOrFail($id);
        return view("article.detail", compact("article"));
    }

    public function indexByTag(Request $request, $id)
    {
        $tags = Tag::with("articles")->find($id);
        $articles = $tags->articles;
        return view("article.index", compact("articles"));
    }
}
