<?php
use yii\widgets\ActiveForm;
use frontend\models\apples\BitForm;
use yii\helpers\Html;

/**
 * Форма укуса
 *
 * @var BitForm $bitForm
 */

$form = ActiveForm::begin([
    'id' => 'eatForm',
    'method' => 'post',
    'action' => '/apples/bit',
    'options' => [
        'class' => 'form ajax-form',
        'style' => 'width:400px; height:150px;'
    ]
]);
echo Html::activeHiddenInput($bitForm, BitForm::_id);
echo $form->field($bitForm, BitForm::_bitPercent)->input('number', [
    'class' => 'form-control'
]);
echo Html::submitButton('Откусить', [
    'class' => 'btn btn-info'
]);
ActiveForm::end();
