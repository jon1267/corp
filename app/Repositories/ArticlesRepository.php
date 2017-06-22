<?php

namespace Corp\Repositories;

use Corp\Article;
use Gate;
use Image;
use Config;

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
        if($this->one($data['alias'], false)) {
            $request->merge(['alias' => $data['alias']]);
            //dd($request);
            $request->flash();// сохранили в сессию все поля объекта $request

            return ['error' => 'Данный псевдоним уже используется'];
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            if($image->isValid()) {

                $str = str_random(8);

                $obj = new \stdClass();
                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);

                $img->fit(Config::get('settings.image')['width'],
                        Config::get('settings.image')['height'])
                        ->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path);

                $img->fit(Config::get('settings.articles_img')['max']['width'],
                    Config::get('settings.articles_img')['max']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max);

                $img->fit(Config::get('settings.articles_img')['mini']['width'],
                    Config::get('settings.articles_img')['mini']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini);

                $data['img'] = json_encode($obj);

                $this->model->fill($data);

                if($request->user()->articles()->save($this->model)) {
                    return ['status' => 'Материал добавлен'];
                }
            }
        }

    }

    public function updateArticle($request, $article) {

        if(Gate::denies('edit', $this->model)) {
            abort(403,'нет права на обновление, ArticleRepo');
        }
        $data = $request->except('_token', 'image', '_method');

        if(empty($data)) {
            return ['error' => 'нет данных'];
        }
        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        $result = $this->one($data['alias'], false);
        //dd($result, $article);

        if($result['id'] != $article->id) {
            $request->merge(['alias' => $data['alias']]);
            //dd($request);
            $request->flash();// сохранили в сессию все поля объекта $request

            return ['error' => 'Данный псевдоним уже используется (updateArticle)'];
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            if($image->isValid()) {

                $str = str_random(8);

                $obj = new \stdClass();
                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);

                $img->fit(Config::get('settings.image')['width'],
                    Config::get('settings.image')['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path);

                $img->fit(Config::get('settings.articles_img')['max']['width'],
                    Config::get('settings.articles_img')['max']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max);

                $img->fit(Config::get('settings.articles_img')['mini']['width'],
                    Config::get('settings.articles_img')['mini']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini);

                $data['img'] = json_encode($obj);
            }
        }
        $article->fill($data);

        if($article->update()) {
            return ['status' => 'Материал обновлен'];
        }

    }

    public function deleteArticle($article) {

        if(Gate::denies('destroy',$article)) {
            abort(403, 'Удаление запрещено');
        }
        // это вызов метода ! comments(), (а не динамич свойства comments)
        // а метод возвращает объект констр. запр. и знач. доступен метод delete()
        // динамич свойство возвращает коллекцию моделей (там вроде нет ??? )
        // т.о. это удаление связанных со статьей комментариев...
        $article->comments()->delete();
        if ($article->delete()) {
            return ['status' => 'Материал удален'];
        }
    }

}