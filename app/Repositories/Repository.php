<?php

namespace Corp\Repositories;

use Config;

abstract class Repository {

    protected $model = false;

    public function get($select = '*', $take = false, $pagination = false, $where = false) {

        $builder = $this->model->select($select);

        if ($take) {
            $builder->take($take);
        }

        if ($where) {
            $builder->where($where[0], $where[1]);
        }

        if ($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    protected function check($result) {

        if ($result->isEmpty()) return false;

        $result->transform(function ($item, $key) {
            if (is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->img = json_decode($item->img);
            }

            return $item;
        });

        return $result;
    }

    public function one($alias, $attr=[]) {

        $result = $this->model->where('alias', $alias)->first();

        return $result;
    }

    public function transliterate($string) {
        $str = mb_strtolower($string, 'UTF-8');
        $letter_array = [
            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г',
            'd' => 'д',
            'e' => 'е,э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и',
            'ji' => '',
            'j' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'kh' => 'х',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'shch' => 'щ',
            'yi' => 'ы',
            '' => 'ь',
            '' => 'ъ',
            'yu' => 'ю',
            'ya' => 'я',
        ];

        foreach ($letter_array as $latin => $cyrillic) {
            $cyrillic = explode(',', $cyrillic);

            $str = str_replace($cyrillic, $latin, $str);
        }
        //A-Za-z0-9-
        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);
        $str = trim($str,'-');

        return $str;
    }

}