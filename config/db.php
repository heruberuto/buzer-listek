<?php
$conf = parse_ini_file('db.ini');
$conf = YII_ENV == 'dev' ? $conf['dev'] : $conf['prod'];

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$conf['host'].';dbname='.$conf['db'],
    'username' => $conf['user'],
    'password' => $conf['password'],
    'charset' => 'utf8',
];
