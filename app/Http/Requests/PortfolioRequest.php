<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false; //return true;
        //return \Auth::user()->canDo('ADD_PORTFOLIOS');
        return \Auth::user()->canDo('ADD_ARTICLES');
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'unique:portfolios|max:255', function($input) {
            //dd($this->route()->hasParameter('portfolio'));
            if($this->route()->hasParameter('portfolio')) {
                 /*этот код не работает, при сохранении, если поменять псевдоним  нет валидации...
                 а все потому, что в public function update(..., $alias) должно быть не $alias
                 а модель (..., Portfolio $portfolio) но тогда были др. глюки. ...разбираться:)*/
                $model = $this->route()->parameter('portfolio');
                //dd($model); //$model == 'masha-bears' те alias !!!
                return ($model !== $input->alias) && !empty($input->alias);
            }
            return !empty($input->alias);
        });
        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'text' => 'required',
            'filter_alias' => 'required',
        ];
    }
}
