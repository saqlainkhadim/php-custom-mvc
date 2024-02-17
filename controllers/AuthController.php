<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        if ($request->isPost()) {
            $register = new RegisterModel();


            $register->loadData($request->body());

//            echo '<pre>';
//            var_dump($register);
//            die;

            if ($register->validate() && $register->register()) {
                return 'success';
            }

            echo '<pre>';
            var_dump($register->errors);
            die;


        }
        return $this->render('register');
    }

}