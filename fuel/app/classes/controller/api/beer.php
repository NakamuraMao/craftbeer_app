<?php

namespace Controller\Api;

use Fuel\Core\Controller_Rest;
use \Model_Beer;
use \DB;

class Beer extends Controller_Rest
{
	protected $format = 'json';

	public function get_index()
	{
		// deleted_at が null のビールのみ取得（論理削除されてないもの）
        $beers = Model_Beer::find('all', [
            'where' => [['deleted_at', 'IS', null]],
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

}
