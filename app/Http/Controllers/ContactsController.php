<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactsController extends SiteController
{
    //
    public function __construct() {
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->bar = 'left';
        $this->template = env('THEME').'.contacts';
    }

    public function index(Request $request) {

        if ($request->isMethod('post')) {

            //если убрать $messages (тут и из $validator) - валидация на англ.
            $messages = [
                'required' => "Поле :attribute обязятельно к заполнению.",
                'email' => "Поле :attribute должно содержать правильный email."
            ];

            $this->validate($request, [
                'name' => 'required|max:191',
                'email' => 'required|email',
                'text' => 'required'
            ], $messages);

            $data = $request->all();

            $result = Mail::send(env('THEME').'.email', ['data'=>$data], function($m) use ($data)  {

                $mail_admin = env('MAIL_ADMIN');
                $m->from($data['email'], $data['name']);
                $m->to($mail_admin, 'Mr. Admin')->subject('Question');
            });

            if (!$result) {
                // вот падшая женщина!!! В уроке было if($result) и работало !!!
                // Наверно в Laravel 5.4 $res = Mail::send() возвращает 0 если все ОК !!!
                return redirect()->route('contacts')->with('status', 'Email was successfully send');
            }

        }

        $this->title = 'Контакты';

        $content = view(env('THEME').'.contact_content')->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $this->contentLeftBar = view(env('THEME').'.contact_bar')->render();

        return $this->renderOutput();
    }

}
