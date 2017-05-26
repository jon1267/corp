<?php

namespace Corp\Repositories;

use Corp\Article;
use Gate;

class ArticlesRepository extends Repository {

    public function __construct(Article $article) {

        $this->model = $article;
    }

    public function one($alias, $attr=[]) {
        $article = parent::one($alias, $attr);

        if ($article && !empty($attr)) {
            $article->load('comments');
            $article->comments->load('user');
        }
        return $article;
    }

    public function addArticle($request) {

        if(Gate::denies('save', $this->model)) {
            abort(403,'нет права на запись, ArticleRepo');
        }
        $data = $request->except('_token', 'image');

        if(empty($data)) {
            return ['error' => 'нет данных'];
        }
        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }
        dd($data);
    }

}