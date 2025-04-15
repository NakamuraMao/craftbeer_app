<?php
//Object-Relational Mapping テーブルのレコードをオブジェクトとして扱う
class Model_Beer extends \Orm\Model
{
    protected static $_table_name = 'beers';

    protected static $_primary_key = ['id'];

    protected static $_properties = [
        'id',
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
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    //日付を自動でセット
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
    //一つのビールが複数のアーカイブを持つ
    protected static $_has_many = [
        'archives' => [
            'key_from' => 'id',
            'model_to' => 'Model_BeerArchive',
            'key_to' => 'beer_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ],
    ];
    //ビールは一人のユーザーに属する
    protected static $_belongs_to = [
        'user' => [
            'key_from'       => 'user_id',
            'model_to'       => 'Model_User',
            'key_to'         => 'id',
            'cascade_save'   => false,
            'cascade_delete' => false,
        ],


    ];
}
