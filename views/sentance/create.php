<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sentance */

$this->title = 'Create Sentance';
$this->params['breadcrumbs'][] = ['label' => 'Sentances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
