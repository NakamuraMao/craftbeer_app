<?php



use Fuel\Core\Controller_Rest;
use Fuel\Core\DB;
use Fuel\Core\Session;
use Fuel\Core\Log;
//use Model_User;

class Controller_Api_User extends Controller_Rest
{
	protected $format = 'json';

	public function post_register()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        //Log::debug('Register POST data: ' . print_r($data, true));

		if(empty($data['username'] || empty($data) || empty($data['password']))){
			return $this->response(['status'=>'error', 'message'=>'Missing required fields'], 404);
		}

        $existing = DB::select()->from('users')->where('email', $data['email'])->execute()->current();
        if($existing){
            return $this->response(['status' => 'error', 'message' => 'Email already exists'], 409);
        }

        $user = Model_User::forge([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
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

		if(empty($data['email'] || $data['password'])){
			return $this->response(['status' => 'error', 'message' => 'Missing email or password...'], 400);
		}

        $user = DB::select()->from('users')->where('email', $data['email'])->execute()->current();

        if($user && password_verify($data['password'], $user['password'])){
            Session::set('user_id', $user['id']);

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
