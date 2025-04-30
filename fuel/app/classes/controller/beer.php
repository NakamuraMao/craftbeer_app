<?php

use Fuel\Core\Controller;
use Fuel\Core\Response;
use Fuel\Core\View;
use Fuel\Core\Session;
use Fuel\Core\Input;
use Fuel\Core\Config;
use Fuel\Core\Log;
class Controller_Beer extends Controller
{

    //各アクション前に共通で処理されるメソッド
    public function before()
    {
        parent::before();

        //もしsessionでログインユーザーが見つからない場合、loginページへ遷移
        if (!Session::get('user_id')) {
            Response::redirect('/login');
        }
        //X-Frame-Options追加 クリックジャッキング対策
        Response::forge()->set_header('X-Frame-Options', 'DENY', true);

        Config::load('site', true); 
        View::set_global('site_name', Config::get('site.site_name'));
    }
    //一覧表示ページ
	public function action_index()
	{
		return Response::forge(View::forge('beer/index'));
	}
    //新規登録ページ
	public function action_create()
    {
        // Rendering the create.php view where the registration form is located
        return Response::forge(View::forge('beer/create'));
    }
    //詳細表示ページ
	public function action_detail()
    {
        // Rendering the create.php view where the registration form is located
        return Response::forge(View::forge('beer/detail'));
    }
    //編集ページ
	public function action_edit()
    {
        //$user_id = Session::get('user_id');
        $beer_id = Input::get('id');
        // Rendering the create.php view where the registration form is located
        return Response::forge(View::forge('beer/edit')
            //->set('user_id', $user_id)
            ->set('beer_id', $beer_id)
        );
    }

	

}
