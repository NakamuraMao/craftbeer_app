<?php

use Fuel\Core\Controller;
use Fuel\Core\Response;
use Fuel\Core\View;
use Fuel\Core\Session;

class Controller_Beer extends Controller
{

	public function action_index()
	{
        if(!Session::get('user_id')){
            Response::redirect('/login');
        }
		return Response::forge(View::forge('beer/index'));
	}

	public function action_create()
    {
        // Rendering the create.php view where the registration form is located
        return Response::forge(View::forge('beer/create'));
    }

	public function action_detail()
    {
        // Rendering the create.php view where the registration form is located
        return Response::forge(View::forge('beer/detail'));
    }

	public function action_edit()
    {
        // Rendering the create.php view where the registration form is located
        return Response::forge(View::forge('beer/edit'));
    }

	

}
