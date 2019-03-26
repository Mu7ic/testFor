<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sentances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать задание', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'text:ntext',
            'datecreate',
            'id_user',
            [
                'attribute' => 'enable',
                'format' => 'raw',
                'value' => function ($model) {
                        if ($model->enable === 0) {
                            return 'Невидим'; // "x" icon in red color
                        }else{
                            return 'Видим'; // check icon
                        }
                    },
            ],
            // 'enable',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
