<?php

namespace App\Services;

use DataTables;

use App\Models\Article;

class ArticleService
{
    /**
     * Get Articles from database.
     *
     */

    public function getArticles($request) {
        $articles = Article::with(['creator'])
            ->select('articles.*')
            ->get();

        return $articles;
    }

    public function getArticleByID($id) {
        $article = Article::with([
            'creator',
        ])->findorFail($id);

        return $article;
    }

    public function storeArticle($request) {
        $newArticle = new Article();
        $newArticle->creator = $request->creator;
        $newArticle->title = $request->title;
        $newArticle->image_url = $request->image_url;
        $newArticle->content = $request->content;

        return $newArticle->save();
    }

    public function updateArticleByID($id, $request) {
        $newArticle = $this->getArticleByID($id);
        $newArticle->creator = $request->creator;
        $newArticle->title = $request->title;
        $newArticle->image_url = $request->image_url;
        $newArticle->content = $request->content;

        return $newArticle->save();
    }

    public function deleteArticleByID($id) {
        $oldArticle = $this->getArticleByID($id);
        $oldArticle = $oldArticle->delete();

        return $oldArticle;
    }
}
