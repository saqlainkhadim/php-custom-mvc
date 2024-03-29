<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {

        $register = new User();
        if ($request->isPost()) {

            $register->loadData($request->body());

            if ($register->validate() && $register->register()) {
                return 'success';
            }

        }

        return $this->render('register',[
            'model' => $register
        ]);
    }

}