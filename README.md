Supplier List by Yii2 and Yii GridView widget

1. Pull code
```shell
git clone git@github.com:hsu1943/supplier-list-by-yii2.git yii2-demo
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

4. Create table and insert data

Run migrate to add table `supplier` ：

```shell
php ./yii migrate
```

Then run command:

```shell
php ./yii mock/supplier
```

Run this command will insert 10 new rows into the table `supplier` each time.

5. Add project to nginx/apache

Assuming that this project have been binding with domain 'demo.test', then you can visit the supplier list page by url `http://demo.test/suppliers`.