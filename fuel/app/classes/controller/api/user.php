<?php



use Fuel\Core\Controller_Rest;
use Fuel\Core\DB;
use Fuel\Core\Session;
use Fuel\Core\Cookie;
use Fuel\Core\Security;
//use Model_User;

class Controller_Api_User extends Controller_Rest
{
    //JSON形式
	protected $format = 'json';

    //sign up用
	public function post_register()
	{
        //フロントからのJSONデータを配列で格納する
		$data = json_decode(file_get_contents('php://input'), true);
        //Log::debug('Register POST data: ' . print_r($data, true));

        //CSRF tokenをチェック
        if (!Security::check_token(@$data['csrf_token'])) {
            return $this->response(['status' => 'error', 'message' => 'Invalid CSRF Token'], 403);
        }

		if(empty($data['username'] || empty($data) || empty($data['password']))){
			return $this->response(['status'=>'error', 'message'=>'Missing required fields'], 404);
		}
        //登録されたemailがすでにDBにあるか確認
        $existing = DB::select('email')->from('users')->where('email', $data['email'])->execute()->current();
        if($existing){
            return $this->response(['status' => 'error', 'message' => 'Email already exists'], 409);
        }

        ////新しいユーザーデータのモデルインスタンスを作成
        $user = Model_User::forge([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),//passwordをハッシュ化
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if($user->save()){
            return $this->response(['status' => 'success', 'message' => 'User successfully registered!']);
        }else{
            return $this->response(['status' => 'error', 'message' => 'Registration failed...'], 500);
        }
	}
	


	public function post_login()
	{
		$data = json_decode(file_get_contents('php://input'), true);


        if (!Security::check_token(@$data['csrf_token'])) {
            return $this->response(['status' => 'error', 'message' => 'Invalid CSRF Token'], 403);
        }

		if(empty($data['email'] || $data['password'])){
			return $this->response(['status' => 'error', 'message' => 'Missing email or password...'], 400);
		}
        //userのemailをDBから取得
        $user = Model_User::query()->where('email', $data['email'])->get_one();
        //$user = DB::select()->from('users')->where('email', $data['email'])->execute()->current();

        if($user && password_verify($data['password'], $user['password'])){
            //sessionをセット
            Session::destroy(); 
            Session::start(); 
            Session::set('user_id', $user['id']);
            //cookieをセット
            // Remember Me（1週間）
            Cookie::set(
                'remember_email',
                $user['email'],
                60 * 60 * 24 * 7,
                '/',
                null,
                true,  // ← secure
                true   // ← httpOnly
            );

            return $this->response([
                'status' => 'success',
                'user_id' => $user['id'],
                'username' => $user['username']
            ]);
        }else{
            return $this->response(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        }


	}


}
