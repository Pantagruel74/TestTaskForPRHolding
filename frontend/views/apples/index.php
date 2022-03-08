<?php
use yii\helpers\Html;
use yii\grid\GridView;
use backend\source\apples\AppleEn;

/**
 * Представление для отображения таблицы с яблоками
 *
 * @var \yii\data\BaseDataProvider $applesDataProvider
 */

/**
 * TODO: Добавить кнопки сбороса и управления временем
 */
?>
<div>
    <?= Html::button('Реинициализировать случайным кол-вом яблок', [
        'onclick' => "window.location.href = '/apples/reinit'",
        'class' => 'btn btn-warning'
    ]) ?>
</div>
<div>
    <?= GridView::widget([
        'dataProvider' => $applesDataProvider,
        'columns' => [
            [
                'label' => 'Яблоки',
                'value' => function ($model)
                {
                    /* @var AppleEn $model */
                    return '<span style="color:#' . $model->color->getHex() . '">&bull;</span>';
                }
            ],
            [
                'label' => 'Создано',
                'value' => function ($model)
                {
                    /* @var AppleEn $model */
                    return '<span style="color:#' . $model->color->getHex() . '">&bull;</span>';
                }
            ],
            /**
             * TODO: Добавить колонок, исправить баги
             */
        ]
    ]) ?>
</div>
