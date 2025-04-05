<?php

use Fuel\Core\Controller;
use Fuel\Core\Response;
use Fuel\Core\View;
use Fuel\Core\Session;

class Controller_UserPage extends Controller
{
    public function action_login()
    {
        return View::forge('user/login');
    }

    public function action_register()
    {
        return View::forge('user/register');
    }

    public function action_logout()
    {
        Session::destroy();
        Response::redirect('/login');
    }
}
