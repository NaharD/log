<?php

use yii\helpers\Html;
use yii\grid\GridView;
use nahard\log\models\Log;
use yii\helpers\Url;

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
<div class="box">
    <div class="box-header box-border">
        <div class="row">
            <div class="col-md-1">
                <a class="btn btn-app">
                    <i class="fa fa-eye" title="Прочитати" onclick="makeRead()"></i> Прочитати
                </a>
            </div>
            <div class="col-md-1 col-md-offset-10">
				<?= Html::dropDownList('dynamicPageSize', Yii::$app->request->get('dynamicPageSize', 40), [
					20 => 20,
					40 => 40,
					60 => 60,
					80 => 80,
				], [
					'form' => 'grid',
					'class' => 'form-control',
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
				'user_id',
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