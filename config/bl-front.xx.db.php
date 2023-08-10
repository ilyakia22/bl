<?php

return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=dbcher',
    //'dsn' => 'pgsql:host=bl_db;port=5432;dbname=dbname',
    'username' => 'dbcher',
    'password' => 'dbcher',
    'charset' => 'utf8',
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
