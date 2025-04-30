<?php

use Fuel\Core\Controller_Rest;
//use Model_Beer;
use \Fuel\Core\Input;
use \Fuel\Core\Session;
use \Fuel\Core\Security;
//use Model_BeerArchive;

class Controller_Api_beerController extends Controller_Rest
{
	//json形式
	protected $format = 'json';

	//一覧表示用
	//$id = null : 一覧表示
	public function get_index($id = null)
	{
		//$id = $id ?: Input::get('id');
		// セッション:ログイン中のユーザーIDを取得
		$user_id = Session::get('user_id');
		//$user_id = Input::get('user_id');

		if(!$user_id){
			return $this->response(['error' => 'Not logged in'], 401);
		}
		//ビールidがある時　= 詳細表示
		if($id){
			// findメソッド IDでビール情報を一つ取得
			$beer = Model_Beer::find($id);

			if(!$beer || $beer->deleted_at !== null || $beer->user_id != Session::get('user_id')){
				return $this->response(['error' => 'Beer not found'], 404);
			}
		
			//1つのビールの詳細データ
			return $this->response([
				'id' => $beer->id,
				'user_id' => $beer->user_id,
				'name' => $beer->name,
				'brewery' => $beer->brewery,
				'type' => $beer->type,
				'ABV' => $beer->ABV,
				'IBU' => $beer->IBU,
				'origin' => $beer->origin,
				'sampled_date' => $beer->sampled_date,
				'appearance' => $beer->appearance,
				'aroma' => $beer->aroma,
				'taste' => $beer->taste,
				'mouthfeel' => $beer->mouthfeel,
				'overall' => $beer->overall,
				'image_url' => $beer->image_url,
				'created_at' => $beer->created_at,
				'updated_at' => $beer->updated_at,
				'deleted_at' => $beer->deleted_at,
			]);
		}
	

		//一覧取得
		// deleted_at が null のビール & user idがdbのuser idと一致
    	$beers = Model_Beer::find('all', [
            'where' => [
				['deleted_at', 'IS', null],
				['user_id', '=', $user_id],
			]
        ]);
		//各ビールデータを配列に格納　JSON形式で返すために
		$result = [];
        foreach ($beers as $beer) {
            $result[] = [
				//キー　＝＞　値
                'id' => $beer->id,
				'user_id' => $beer->user_id,
                'name' => $beer->name,
                'brewery' => $beer->brewery,
                'type' => $beer->type,
                'ABV' => $beer->ABV,
                'IBU' => $beer->IBU,
                'origin'        => $beer->origin,
				'sampled_date'  => $beer->sampled_date,
				'appearance'    => $beer->appearance,
				'aroma'         => $beer->aroma,
				'taste'         => $beer->taste,
				'mouthfeel'     => $beer->mouthfeel,
				'overall'       => $beer->overall,
				'image_url'     => $beer->image_url,
				'created_at'    => $beer->created_at,
				'updated_at'    => $beer->updated_at,
				'deleted_at'    => $beer->deleted_at,
            ];
        }

        return $this->response($result);
    
	}
	

	//新規登録用
	public function post_index()
	{
		//フロントからのJSONデータを配列で格納する
		//FuelPHPでAPIを受け取るとき、フロントエンドからJSONデータを送ってくるからそれをPHPで使える形にしている
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = Session::get('user_id');

		//CSRF tokenをチェック
		if (!Security::check_token(@$data['csrf_token'])) {
			return $this->response(['error' => 'Invalid CSRF Token'], 403);
		}

		if(!isset($data['name'], $data['brewery'])){
			return $this->response(['error' => 'Name and Brewery are required'], 400);
		}

		// Ensure sampled_date is in the correct format if it's a string
		$sampled_date = isset($data['sampled_date']) ? date('Y-m-d', strtotime($data['sampled_date'])) : null;

		//新しいビールデータのモデルインスタンスを作成
		$beer = Model_Beer::forge([
            //'user_id' => isset($data['user_id']) ? $data['user_id'] : null,  // ユーザーIDがあれば設定
			'user_id' => $user_id,
            'name' => $data['name'],
            'brewery' => $data['brewery'],  // ブランド名
			//isset キーがあるか　$data['']があればその値をセット　なければnull
            'type' => isset($data['type']) ? $data['type'] : null,  // 種類
            'IBU' => isset($data['IBU']) ? $data['IBU'] : null,  // 苦味
            'ABV' => isset($data['ABV']) ? $data['ABV'] : null,  // アルコール度数
            'origin' => isset($data['origin']) ? $data['origin'] : null,  // 生産地
            'sampled_date' => isset($data['sampled_date']) ? $data['sampled_date'] : null,  // 試飲日
            'appearance' => isset($data['appearance']) ? $data['appearance'] : null,  // 見た目
            'aroma' => isset($data['aroma']) ? $data['aroma'] : null,  // 香り
            'taste' => isset($data['taste']) ? $data['taste'] : null,  // 味
            'mouthfeel' => isset($data['mouthfeel']) ? $data['mouthfeel'] : null,  // 舌触り
            'overall' => isset($data['overall']) ? $data['overall'] : null,  // 全体評価
            'image_url' => isset($data['image_url']) ? $data['image_url'] : null,  // 画像URL
        ]);

		if($beer->save()){
			return $this->response(['success' => 'Beer successfully added!'], 200);
		}else{
			return $this->response(['error' => 'Failed to save beer...'], 500);
		}


	}

	//編集用
	public function put_index(){
		$data = json_decode(file_get_contents('php://input'), true);

		$user_id = Session::get('user_id');

		if (!Security::check_token(@$data['csrf_token'])) {
			return $this->response(['error' => 'Invalid CSRF Token'], 403);
		}

		if (!isset($data['id'])) {
			return $this->response(['error' => 'ID is required for update'], 400);
		}
	
		//IDで一つのビールデータを取得
		$beer = Model_Beer::find($data['id']);
	
		if (!$beer || $beer->deleted_at !== null) {
			return $this->response(['error' => 'Beer not found'], 404);
		}
		//DBのuser_idとsessionで取得したログイン中のuser_idを比べる
		if($beer->user_id !== $user_id){
			return $this->response(['error' => 'Unauthorized'], 403);
		}
		// 値が存在すれば更新
		//$data['']がnullかどうか　$x がnullなら $y
		$beer->name         = $data['name'] ?? $beer->name;
		$beer->brewery      = $data['brewery'] ?? $beer->brewery;
		$beer->type         = $data['type'] ?? $beer->type;
		$beer->IBU          = $data['IBU'] ?? $beer->IBU;
		$beer->ABV          = $data['ABV'] ?? $beer->ABV;
		$beer->origin       = $data['origin'] ?? $beer->origin;
		$beer->sampled_date = $data['sampled_date'] ?? $beer->sampled_date;
		$beer->appearance   = $data['appearance'] ?? $beer->appearance;
		$beer->aroma        = $data['aroma'] ?? $beer->aroma;
		$beer->taste        = $data['taste'] ?? $beer->taste;
		$beer->mouthfeel    = $data['mouthfeel'] ?? $beer->mouthfeel;
		$beer->overall      = $data['overall'] ?? $beer->overall;
		$beer->image_url    = $data['image_url'] ?? $beer->image_url;
		//$beer->user_id      = $data['user_id'] ?? $beer->user_id;
	
		if ($beer->save()) {
			return $this->response(['success' => 'Beer successfully updated!'], 200);
		} else {
			return $this->response(['error' => 'Failed to update beer...'], 500);
		}

	}

	public function delete_index($id = null)
	{
		$user_id = Session::get('user_id');

		$data = json_decode(file_get_contents('php://input'), true);

		if (!Security::check_token(@$data['csrf_token'])) {
			return $this->response(['error' => 'Invalid CSRF Token'], 403);
		}


		if (!$id) {
			return $this->response(['error' => 'ID is required'], 400);
		}

		$beer = Model_Beer::find($id);

		if (!$beer || $beer->deleted_at !== null) {
			return $this->response(['error' => 'Beer not found'], 404);
		}

		if($beer->user_id !== $user_id){
			return $this->response(['error' => 'Unauthorized'], 403);
		}

		//削除されたデータを保存するアーカイブ用
		$archive = Model_BeerArchive::forge([
			'beer_id'      => $beer->id,
			'user_id'      => $beer->user_id,
			'name'         => $beer->name,
			'brewery'      => $beer->brewery,
			'type'         => $beer->type,
			'ABV'          => $beer->ABV,
			'IBU'          => $beer->IBU,
			'origin'       => $beer->origin,
			'sampled_date' => $beer->sampled_date,
			'appearance'   => $beer->appearance,
			'aroma'        => $beer->aroma,
			'taste'        => $beer->taste,
			'mouthfeel'    => $beer->mouthfeel,
			'overall'      => $beer->overall,
			'image_url'    => $beer->image_url,
			'deleted_at'   => date('Y-m-d H:i:s'),
		]);
		$archive->save();
		//beers tableのdeleted_atを更新
		$beer->deleted_at = date('Y-m-d H:i:s');
		$beer->save();

		return $this->response(['success' => 'Beer deleted and archived'], 200);
	}


}
