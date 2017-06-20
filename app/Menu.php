<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title', 'path', 'parent'
    ];

    /**
     * todo: переопределяем стандартный открытый метод delete() модели
     *
     * @return bool|null
     */
    public function delete(array $options = [])
    {
        // $this-> будет объект удаляемой ссылки меню.
        // self:: будет обращение к классу Menu (те к модели Menu)
        // стр ниже, это выбраны все дочерн элементы для удаляемого родителя.
        //$child = self::where('parent', $this->id);
        //$child->delete();
        self::where('parent', $this->id)->delete();

        return parent::delete($options);
    }
}
