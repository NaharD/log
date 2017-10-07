<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'category',
            'message:ntext',
            'created_at:datetime',
            'user_id',
//            'id',
//            'level',
//            'updated_at:datetime',
//            'ip',
//            'var:ntext',
//            'referrer_url:ntext',
//            'request_url:ntext',
//            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
