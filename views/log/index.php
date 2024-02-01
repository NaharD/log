<?php

use yii\helpers\Html;
use yii\grid\GridView;
use nahard\log\models\Log;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel nahard\log\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;

$makeReadUrl = Url::to(['make-read']);
$jsStatusUpdate = <<<JS

    function makeRead(ids)
    {
        if (ids === undefined) {
            ids = $('#grid').yiiGridView('getSelectedRows');
        }
        
        if( ids.length > 0 ){
            (function waterfall(i){
                if (i == ids.length) {
                    return false;
                }
                
                $.get( "{$makeReadUrl}", { ids: {'': ids[i]} }).done(function( data ) {
                    $("tr[data-key=" + ids[i] + "]").removeClass('bg-yellow');
                }).always(function() {
                    waterfall(i + 1);
                });
            })(0);
        }
        
        return false;
    }
JS;
$this->registerJs($jsStatusUpdate, \yii\web\View::POS_END);
?>
<div class="transaction-index box box-primary collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title">Additional search</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="box-body table-responsive" style="display: none;">
        <div class="click-search">
            <?php $form = ActiveForm::begin([
                'id' => 'logSearchId',
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
            ]); ?>

            <?= $form->field($searchModel, 'var') ?>
            <?= $form->field($searchModel, 'referrer_url') ?>
            <?= $form->field($searchModel, 'referrer_url') ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="box-footer">
            <div class="form-group no-margin">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'form' => 'logSearchId']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default pull-right', 'form' => 'logSearchId']) ?>
            </div>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-header box-border">
        <div class="row">
            <div class="col-xs-2">
                <a class="btn btn-app">
                    <i class="fa fa-eye" title="Прочитати" onclick="makeRead()"></i> Прочитати
                </a>
            </div>
            <div class="col-xs-10 col-xs-offset-84">
				<?= Html::dropDownList('dynamicPageSize', Yii::$app->request->get('dynamicPageSize', 40), [
					20 => 20,
					40 => 40,
					60 => 60,
					80 => 80,
				], [
					'form' => 'grid',
					'class' => 'form-control pull-right',
					'style' => "width: 80px; height: 60px; font-size: 19px; background-color: #f4f4f4; cursor: pointer;",
				])?>
            </div>
        </div>
    </div>

    <div class="box-body">
		<?= GridView::widget([
			'id' => 'grid',
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'filterSelector' => 'select[name="dynamicPageSize"]',
			'rowOptions' => function ($model) {
				if (!$model->isReaded())
					return ['class' => 'bg-yellow'];
			},
            'options' => [
                'class' => 'table-responsive'
            ],
			'columns' => [
				[
					'class' => 'yii\grid\CheckboxColumn',
					'checkboxOptions' => false,
				],
				['class' => 'yii\grid\SerialColumn'],
				
				'category',
				[
					'attribute' => 'message',
					'format' => 'ntext',
					'contentOptions' => ['style' => 'word-break:break-all'],
					'value' => function($model) {
						return substr($model->message, 0, 400);
					}
				],
				'created_at:datetime',
                [
                    'attribute' => 'user_id',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'word-break:break-all'],
                    'value' => function($model) {
		                if ($user_id = $model->user_id) {
                            if ($userCallback = Yii::$app->controller->module->userCallback) {
                                return $userCallback($user_id);
                            }
                            return $user_id;
                        }
                    }
                ],
				//            'id',
				//            'level',
				//            'updated_at:datetime',
				//            'ip',
				//            'var:ntext',
				//            'referrer_url:ntext',
				//            'request_url:ntext',
				[
					'attribute' => 'status',
					'filter' => Log::getStatusList(),
					'value' => function($model) {
						return Log::getStatusLabel($model->status);
					}
				],
				
				['class' => 'yii\grid\ActionColumn'],
			],
		]); ?>
    </div>
</div>