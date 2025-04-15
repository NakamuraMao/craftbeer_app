<?php

class Model_BeerArchive extends \Orm\Model
{
    //テーブル名
    protected static $_table_name = 'beers_archives';

    protected static $_primary_key = ['id'];

    // カラム一覧
    protected static $_properties = [
        'id',
        'beer_id',
        'user_id',
        'name',
        'brewery',
        'type',
        'IBU',
        'ABV',
        'origin',
        'sampled_date',
        'appearance',
        'aroma',
        'taste',
        'mouthfeel',
        'overall',
        'image_url',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    // 自動で日付を更新
    protected static $_observers = [
        'Orm\\Observer_CreatedAt' => [
            'events' => ['before_insert'],
            'property' => 'created_at',
            'mysql_timestamp' => true,
        ],
        'Orm\\Observer_UpdatedAt' => [
            'events' => ['before_update'],
            'property' => 'updated_at',
            'mysql_timestamp' => true,
        ],
    ];

    
    protected static $_belongs_to = [
        // ビールアーカイブは一人のユーザーに属する
        'user' => [
            'key_from' => 'user_id',
            'model_to' => 'Model_User',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ],
        // ビールアーカイブは一つのビールに属する
        'beer' => [
        'key_from' => 'beer_id',
        'model_to' => 'Model_Beer',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    ],
    ];
}
