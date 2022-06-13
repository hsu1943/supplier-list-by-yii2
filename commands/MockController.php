<?php

namespace app\commands;

use app\models\Supplier;
use Yii;
use yii\console\Controller;
use yii\db\Exception;

class MockController extends Controller
{
    public function actionSupplier()
    {
        echo 'generate supplier data ...' . PHP_EOL;
        $list = [];
        $existCode = Supplier::find()->select('code')->asArray()->column();
        $count = count($existCode);
        $status = ['ok', 'hold'];
        for ($i = 0; $i < 10; $i ++) {
            $list[] = [
                'YH_' . ($count + $i + 1),
                strtoupper($this->randCode(array_merge($existCode, array_column($list, 'code')))),
                $status[rand(0, count($status) - 1)]
            ];
        }
        try {
            $res = Yii::$app->db->createCommand()->batchInsert(Supplier::tableName(), ['name', 'code', 't_status'], $list)->execute();
            echo '插入数据' . $res . '条' . PHP_EOL;
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

    }

    public function randCode($arr)
    {
        $code = $this->realUniqid(3);
        while (in_array($code, $arr)) {
            $code = $this->realUniqid(3);
        }
        return $code;
    }

    public function realUniqid($length = 3)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $length);
    }


}