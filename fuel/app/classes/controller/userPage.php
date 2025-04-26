<?php

use Fuel\Core\Controller;
use Fuel\Core\Response;
use Fuel\Core\View;
use Fuel\Core\Session;
use Fuel\Core\Cookie;
use Fuel\Core\Config;
use Fuel\Core\Log;

class Controller_UserPage extends Controller
{
    protected $view; // Viewオブジェクトをクラスで持つ

    //各アクション前に共通で処理されるメソッド
    public function before()
    {
        parent::before();

        // iframe埋め込み防止
        Response::forge()->set_header('X-Frame-Options', 'DENY', true);

        Config::load('site', true); 
        View::set_global('site_name', Config::get('site.site_name'));
    }

    public function action_login()
    {
        $email = Cookie::get('remember_email'); // Cookieから取得（存在しなければ null）
        return View::forge('user/login', [
            'remember_email' => $email // ビューに渡す
        ]);

    }

    public function action_register()
    {
        return View::forge('user/register');
    }

    public function action_logout()
    {
        Session::destroy();
        Cookie::delete('remember_email'); // Cookieも削除
        Response::redirect('/login');
    }
}
