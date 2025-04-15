<?php

class Model_User extends \Orm\Model
{
    //テーブル名
    protected static $_table_name = 'users';
    //primary key
    protected static $_primary_key = ['id'];
    //カラム一覧
    protected static $_properties = [
        'id',
        'username',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];
    //日付を自動で更新
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
    
    protected static $_has_many = [
        //一人のユーザーは複数のビールを持つ
        'beers' => [
            'key_from' => 'id',
            'model_to' => 'Model_Beer',
            'key_to' => 'user_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ],
        //一人のユーザーは複数のビールアーカイブを持つ
        'beer_archives' => [
            'key_from' => 'id',
            'model_to' => 'Model_BeerArchive',
            'key_to' => 'user_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ],
    ];
}
