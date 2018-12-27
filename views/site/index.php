<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Orbital';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>

        <p class="lead">Enter your name:</p>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->label('') ?>

        <div class="form-group">
            <?= Html::submitButton('OK', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
