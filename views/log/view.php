<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use nahard\log\models\Log;

/* @var $this yii\web\View */
/* @var $model nahard\log\models\Log */

$this->title = "Помилка з ідентифікатором {$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="log-view">
    <p>
        <?= Html::a('Змінити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => "Дійсно видалити помилку з ідентифікатором {{$model->id}}",
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level',
            'category',
            'created_at:datetime',
            'updated_at:datetime',
			'referrer_url:text',
			'request_url:text',
            'ip',
			'user_id',
			'status',
			'var:ntext',
			[
				'attribute' => 'status',
				'value' => function($model) {
					return Log::getStatusLabel($model->status);
				}
			],
            'user_agent',
			[
				'attribute' => 'message',
				'format' => 'ntext',
				'contentOptions' => ['style' => 'word-break:break-all'],
			],
        ],
    ]) ?>

</div>
