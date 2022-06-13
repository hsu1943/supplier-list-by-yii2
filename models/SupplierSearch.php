<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class SupplierSearch extends Supplier
{
    public $pageSize;
    public $sort;
    public $tStatus;
    public $idFilter;
    public $ids;
    public $columns;

    public function rules()
    {
        return ArrayHelper::merge(
            [
                [['sort', 'pageSize', 'tStatus','idFilter', 'ids', 'columns'], 'safe']
            ],
            parent::rules()
        );
    }

    public function search($params, $export=false)
    {
        Yii::info($params);
        $query = self::find();

        if (!isset($params['sort'])) {
            $query->orderBy([self::tableName() . '.id' => SORT_DESC]);
        }

        $this->load($params, '');

        if (!$this->validate()) {
            Yii::info($this->firstErrors);
            goto end;
        }

        if (!empty($this->name)) {
            $query->andFilterWhere(['like', self::tableName() . '.name', $this->name]);
        }

        if (!empty($this->code)) {
            $query->andFilterWhere(['like', self::tableName() . '.code', $this->code]);
        }

        // id filter
        if (empty($this->idFilter)) {
            $this->idFilter = 'ALL';
        }

        if ($this->idFilter != 'ALL') {
            // id < 10 | id >= 10, id <= 10
            $query->andWhere([$this->idFilter, self::tableName() . '.id', 10]);
        }

        // t_status filter
        if (empty($this->tStatus)) {
            $this->tStatus = 'ALL';
        }

        if ($this->tStatus != 'ALL') {
            $query->andWhere([self::tableName() . '.t_status' => strtolower($this->tStatus)]);
        }

        end:

        // export
        if ($export) {
            if (!empty($this->ids)) {
                $query->andWhere(['in', self::tableName() . '.id', $this->ids]);
            }
            $query->select($this->columns);
            return $query->asArray()->all();
        } else {
            $dataProvider = new ActiveDataProvider([
                'query'      => $query,
                'pagination' => [
                    'defaultPageSize' => $this->pageSize ? : 10,
                    'pageParam'       => 'currentPage',
                    'pageSizeParam'   => 'pageSize',
                    'pageSizeLimit'   => [1, 1000],
                    'validatePage'    => false
                ]
            ]);

            /* @var $model Supplier */
            foreach ($dataProvider->models as $model) {
                $model->scenario = 'list';
            }
            return $dataProvider;
        }
    }

}