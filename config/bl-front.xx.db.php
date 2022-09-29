<?php

return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'dsn' => 'pgsql:host=bl_db_bouncer;port=6432;dbname=dbname',
    //'dsn' => 'pgsql:host=bl_db;port=5432;dbname=dbname',
    'username' => 'dbuser',
    'password' => 'dbpwd',
    'charset' => 'utf8',
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
