Supplier List by Yii2 and Yii GridView widget

1. Pull code
```shell
git clone  yii2-demo
```

2. Composer install
```shell
composer install -vvv
```

3. Edit config db(mysql) connect

Edit your mysql connect information in file `/config/common.php`

```php
...

'db' => [
    'class'    => 'yii\db\Connection',
    'dsn'      => 'mysql:host=127.0.0.1;dbname=yii2-demo',
    'username' => 'test',
    'password' => 'test',
    'charset'  => 'utf8mb4',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
]
...
```

4. Mock data

Enter the project root directory and run command:

```shell
php ./yii mock/supplier
```

This command will insert 10 new rows into the table `supplier` one time.

Assuming that this project have been binded with domain 'demo.test', then you can visit the supplier list page by url `http://demo.test/suppliers`.