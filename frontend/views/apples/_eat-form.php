<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'eatForm',
    'method' => 'post',
    'action' => '/apples/bit',
    'options' => [
        'class' => 'form ajax-form',
        'style' => 'width:400px; height:150px;'
    ]
]);
?>
    <div class="form-group">
        <label><b>Откусить, %</b></label>
        <?= Html::input('number', 'eat', '0', [
            'class' => 'form-control'
        ]) ?>
    </div>
    <?= Html::submitButton('Откусить', [
        'class' => 'btn btn-info'
    ]) ?>
<?php
ActiveForm::end();
