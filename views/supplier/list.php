<?php

/** @var yii\web\View $this */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $searchModel SupplierSearch */

use app\models\Supplier;
use app\models\SupplierSearch;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title                   = 'Suppliers List Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-customer">
    <div class="col-md-12 site-customer-row">
        <div class="alert alert-info" role="alert" id="select-all-page">
            <button type="button" class="close" aria-label="Close" onclick="$('#select-all-page').hide()"><span
                        aria-hidden="true">&times;</span></button>
            All <span id="page_num">50</span> conversations on this page have been selected.
            <a href="#" class="alert-link" id="do-select-all-page"> Select all conversations that match this search</a>
        </div>
        <div class="alert alert-info" role="alert" id="clear-selection">
            <button type="button" class="close" aria-label="Close" onclick="$('#clear-selection').hide()"><span
                        aria-hidden="true">&times;</span></button>
            All conversations in this search have been selected.
            <a href="#" class="alert-link" id="do-clear-selection"> Clear selection</a>
        </div>
        <div class="alert alert-danger" role="alert" id="select-none">
            <button type="button" class="close" aria-label="Close" onclick="$('#select-none').hide()"><span
                        aria-hidden="true">&times;</span></button>
            Please select any row(s) before export.
        </div>
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <button class="btn btn-sm btn-success pull-right" id="export" data-toggle="modal"
                    data-target="#export-confirm">Export
            </button>
        </div>
        <div class="clearfix"></div>
        <?php
        try {
            $columns          = [
                [
                    'class'         => 'yii\grid\CheckboxColumn',
                    'headerOptions' => ['id' => 'check_all']
                ],
                [
                    'attribute' => 'idFilter',
                    'label'     => 'ID',
                    'filter'    => [
                        'ALL' => 'ALL',
                        '<'   => 'id < 10',
                        '<='  => 'id <= 10',
                        '>='  => 'id >= 10',
                        '>'   => 'id > 10'
                    ],
                    'value'     => function (Supplier $model) {
                        return $model->id;
                    }

                ],
                [
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'code',
                ],
                [
                    'attribute' => 'tStatus',
                    'label'     => 'T Status',
                    'filter'    => [
                        'ALL'  => 'ALL',
                        'OK'   => 'OK',
                        'HOLD' => 'HOLD'
                    ],
                    'value'     => function (Supplier $model) {
                        return $model->t_status;
                    }
                ],
            ];
            $pageSizeSelector = Html::activeDropDownList(
                $searchModel,
                'pageSize',
                [10 => "10 rows/page", 20 => "20 rows/page", 50 => "50 rows/page", 100 => "100 rows/page"],
                ['id' => 'pageSizeSelector', 'class' => 'form-control']
            );
            echo GridView::widget([
                'id'             => 'grid',
                'dataProvider'   => $dataProvider,
                'filterModel'    => $searchModel,
                'layout'         => '<div class="summary-h">{summary}</div>{items}{pager}' . $pageSizeSelector,
                'filterSelector' => '#pageSizeSelector',
                'pager'          => [
                    'options' => [
                        'class' => 'pagination pull-right'
                    ]
                ],
                'columns'        => $columns,
            ]);
        } catch (Exception $e) {
            echo "get data list error：" . $e->getMessage();
        }
        ?>
    </div>

    <!--create modal-->
    <div class="modal fade" id="export-confirm" tabindex="-1" role="dialog" aria-labelledby="export-confirm-label"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="export-confirm-label">Export selected rows to a CSV file</h4>
                </div>
                <div class="modal-body" style="min-height: 0;">
                    <form>
                        <div class="form-group">
                            <label>Please Select Columns</label>
                            <div class="checkbox-input-div"><input type="checkbox" class="checkbox-input-row" name="id"
                                                                   disabled checked> <span>ID</span></div>
                            <div class="checkbox-input-div"><input type="checkbox" class="checkbox-input-row"
                                                                   name="name"> <span>Name</span></div>
                            <div class="checkbox-input-div"><input type="checkbox" class="checkbox-input-row"
                                                                   name="code"> <span>Code</span></div>
                            <div class="checkbox-input-div"><input type="checkbox" class="checkbox-input-row"
                                                                   name="t_status"> <span>T Status</span></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success export-confirm">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

</div>
