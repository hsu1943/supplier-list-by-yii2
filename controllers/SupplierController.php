<?php

namespace app\controllers;

use app\models\SupplierSearch;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SupplierController extends Controller
{
    public function actionList()
    {
        $params = Yii::$app->request->getQueryParam('SupplierSearch');
        if (Yii::$app->request->getQueryParam('sort')) $params['sort'] = Yii::$app->request->getQueryParam('sort');
        $searchModel  = new SupplierSearch();
        $dataProvider = $searchModel->search($params);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    public function actionExport()
    {
        // download file
        $file = Yii::$app->request->getQueryParam('file');
        if ($file) {
            return Yii::$app->response->sendFile($file);
        }

        // get data list
        $params = Yii::$app->request->getQueryParam('SupplierSearch');
        $post = Yii::$app->request->getBodyParams();
        if (!$post['all_page']) {
            $params['ids'] = $post['ids'];
        }
        $params['columns'] = $post['columns'];
        $searchModel  = new SupplierSearch();
        $data = $searchModel->search($params, true);

        try {
            $file = $this->doExport($data, $post['columns']);
            return $this->redirect(Url::to(['export', 'file' => $file]));
        } catch (\Exception $e) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['params' => $params, 'post' => $post, 'data' => $data];
        }
    }

    public function doExport($data, $columns)
    {
        $columnsArr = [];
        foreach ($columns as $column) {
            $columnsArr[$column] = strtoupper($column);
        }
        $data = array_merge([$columnsArr], $data);
        $fileName = date('Ymd_His_') . substr(md5(uniqid('', true)), 0, 8) . '.csv';
        $exportFile = Yii::getAlias('@runtime/' . $fileName);
        $fp = fopen ( $exportFile , 'w' );
        foreach ( $data as $fields ) {
            fputcsv ( $fp , array_map(function ($field){
                return "\xEF\xBB\xBF" . $field;
            }, $fields) );
        }
        fclose( $fp );
        return $exportFile;
    }

}