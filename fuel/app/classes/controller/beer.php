<?php

use Fuel\Core\Controller;
use Fuel\Core\Response;
use Fuel\Core\View;

class Controller_Beer extends Controller
{

	public function action_index()
	{
		return Response::forge(View::forge('beer/index'));
	}

}
