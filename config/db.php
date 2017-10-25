<?php
$conf = parse_ini_file('db.ini');
$conf = YII_ENV == 'dev' ? $conf['dev'] : $conf['prod'];

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=buzerlistek',
    'username' => 'admin',
    'password' => 'admin',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql' => [
            'class' => 'yii\db\pgsql\Schema',
            'defaultSchema' => 'public' //specify your schema here
        ]
    ],
];
