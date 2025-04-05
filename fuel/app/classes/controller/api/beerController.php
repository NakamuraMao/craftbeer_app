<?php



use Fuel\Core\Controller_Rest;
//use Model_Beer;
use \Fuel\Core\Input;
use \Fuel\Core\Session;
//use Model_BeerArchive;

class Controller_Api_beerController extends Controller_Rest
{
	protected $format = 'json';

	public function get_index($id = null)
	{
		$id = $id ?: Input::get('id');
		$user_id = Session::get('user_id');
		//$user_id = Input::get('user_id');

		if(!$user_id){
			return $this->response(['error' => 'Not logged in'], 401);
		}

		if($id){
			$beer = Model_Beer::find($id);

			if(!$beer || $beer->deleted_at !== null){
				return $this->response(['error' => 'Beer not found'], 404);
			}
		

			return $this->response([
				'id' => $beer->id,
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
	


		// deleted_at が null のビールのみ取得（論理削除されてないもの）
    	$beers = Model_Beer::find('all', [
            'where' => [
				['deleted_at', 'IS', null],
				['user_id', '=', $user_id],
			]
        ]);

		$result = [];
        foreach ($beers as $beer) {
            $result[] = [
                'id' => $beer->id,
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
	


	public function post_index()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = Session::get('user_id');

		if(!isset($data['name'], $data['brewery'])){
			return $this->response(['error' => 'Name and Brewery are required'], 400);
		}

		// Ensure sampled_date is in the correct format if it's a string
		$sampled_date = isset($data['sampled_date']) ? date('Y-m-d', strtotime($data['sampled_date'])) : null;

		$beer = Model_Beer::forge([
            //'user_id' => isset($data['user_id']) ? $data['user_id'] : null,  // ユーザーIDがあれば設定
			'user_id' => $user_id,
            'name' => $data['name'],
            'brewery' => $data['brewery'],  // ブランド名
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


	public function put_index(){
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = Session::get('user_id');

		if (!isset($data['id'])) {
			return $this->response(['error' => 'ID is required for update'], 400);
		}
	
		$beer = Model_Beer::find($data['id']);
	
		if (!$beer || $beer->deleted_at !== null) {
			return $this->response(['error' => 'Beer not found'], 404);
		}
	
		if($beer->user_id !== $user_id){
			return $this->response(['error' => 'Unauthorized'], 403);
		}
		// 値が存在すれば更新
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
		$beer->user_id      = $data['user_id'] ?? $beer->user_id;
	
		if ($beer->save()) {
			return $this->response(['success' => 'Beer successfully updated!'], 200);
		} else {
			return $this->response(['error' => 'Failed to update beer...'], 500);
		}

	}

	public function delete_index($id = null)
	{
		$user_id = Session::get('user_id');
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

		$beer->deleted_at = date('Y-m-d H:i:s');
		$beer->save();

		return $this->response(['success' => 'Beer deleted and archived'], 200);
	}


}
