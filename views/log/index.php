<?php

use yii\helpers\Html;
use yii\grid\GridView;
use nahard\log\models\Log;

/* @var $this yii\web\View */
/* @var $searchModel nahard\log\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'rowOptions' => function ($model) {
			if (!$model->isReaded())
				return ['class' => 'bg-yellow'];
		},
        'columns' => [
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
