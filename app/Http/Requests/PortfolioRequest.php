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

            if($this->route()->hasParameter('portfolios')) {

                // этот код не работает, при сохранении если псевдоним не менять нет валидации...
                // а все потому, что в public function update(..., $alias) должно быть не $alias
                // а модель (..., Portfolio $portfolio) но тогда были др. глюки. ...разбираться:)
                $model = $this->route()->parameter('portfolios');

                // ??? $model->alias
                return ($model != $input->alias) && !empty($input->alias);
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
