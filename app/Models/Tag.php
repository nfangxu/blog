<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    public function articles()
    {
        return $this->belongsToMany(Article::class, "article_tag")
            ->where("status", 1)
            ->orderBy("updated_at", "desc");
    }
}
