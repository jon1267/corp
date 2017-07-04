<?php

namespace Corp\Repositories;

use Corp\Portfolio;
use Gate;
use Image;
use Config;

class PortfoliosRepository extends Repository
{
    public function __construct(Portfolio $portfolio) {
        $this->model = $portfolio;
    }

    public function one($alias, $attr = []) {
        $portfolio = parent::one($alias, $attr);

        if($portfolio && $portfolio->img) {
            $portfolio->img = json_decode($portfolio->img);
        }
        return $portfolio;
    }

    public function addPortfolio($request) {
        /*if(Gate::denies('save', $this->model)) {
            abort(403, 'Нет прав добавлять репозиторий');
        }*/
        $data = $request->except('_token', 'img');

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }
        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }
        //dd($data);
        if($this->one($data['alias'], false)) {
            // merge() добавит в объект $request массив []
            $request->merge(['alias' => $data['alias']]);
            //dd($request);
            $request->flash();//сохранить $request в сессии

            return ['error' => 'Данный псевдоним уже используется'];
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            if($image->isValid()) {
                $str = str_random(8);
                //формируем обычный php объект через ф-цию php stdClass();
                $obj = new \stdClass();
                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);
                //dd($img);
                $img->fit(Config::get('settings.image')['width'],
                    Config::get('settings.image')['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->path);

                $img->fit(Config::get('settings.portfolios_img')['max']['width'],
                    Config::get('settings.portfolios_img')['max']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->max);

                $img->fit(Config::get('settings.portfolios_img')['mini']['width'],
                    Config::get('settings.portfolios_img')['mini']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->mini);
                //dd('hello');//смотрим, чтоб в папке /images/projects/ появились ...mini.jpg ..._max.jpg
                //формируем строку типа {"mini":"..._mini.jpg","max":"..._max.jpg","path":"...jpg"}
                $data['img'] = json_encode($obj);
                //dd($data);

                //$this->model->fill($data);
                //dd($this->model);

                //$request->portfolio()->save($this->model)
                if($this->model->fill($data)->save()) {
                    return ['status' => 'Портфолио добавлено'];
                }
            }
        }
    }

    public function updatePortfolio($request, $portfolio) {
        /*if(Gate::denies('save', $this->model)) {
            abort(403, 'Нет прав добавлять репозиторий');
        }*/
        $data = $request->except('_token', 'img', '_method');

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }
        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        $result = $this->one($data['alias'], false);
        dd($data, $result); // ??? $result == null

        if($result['id'] != $portfolio->id) {
            // merge() добавит в объект $request массив []
            $request->merge(['alias' => $data['alias']]);
            //dd($request);
            $request->flash();//сохранить $request в сессии

            return ['error' => 'Данный псевдоним уже используется'];
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            if($image->isValid()) {
                $str = str_random(8);
                //формируем обычный php объект через ф-цию php stdClass();
                $obj = new \stdClass();
                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);
                //dd($img);
                $img->fit(Config::get('settings.image')['width'],
                    Config::get('settings.image')['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->path);

                $img->fit(Config::get('settings.portfolios_img')['max']['width'],
                    Config::get('settings.portfolios_img')['max']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->max);

                $img->fit(Config::get('settings.portfolios_img')['mini']['width'],
                    Config::get('settings.portfolios_img')['mini']['height'])
                    ->save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->mini);
                //dd('hello');//смотрим, чтоб в папке /images/projects/ появились ...mini.jpg ..._max.jpg
                //формируем строку типа {"mini":"..._mini.jpg","max":"..._max.jpg","path":"...jpg"}
                $data['img'] = json_encode($obj);
                //dd($data);
            }
        }
        $portfolio->fill($data);
        //dd($portfolio);
        if($portfolio->update()) {
            return ['status' => 'Портфолио обновлено'];
        }
    }


}