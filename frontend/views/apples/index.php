<?php
use yii\helpers\Html;
use yii\grid\GridView;
use backend\source\apples\AppleEn;
use backend\source\apples\AppleStatusVO;

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
                    return '<span style="color:#' . $model->color->getHex() . '">&#9899;</span>';
                },
                'format' => 'raw',
            ],
            [
                'label' => 'Создано',
                'value' => function ($model)
                {
                    /* @var AppleEn $model */
                    return Yii::$app->formatter->asDateTime($model->createdAt, 'dd.MM.YYYY (HH:mm)');
                }
            ],
            [
                'label' => 'Статус',
                'value' => function ($model)
                {
                    /* @var AppleEn $model */
                    $result = AppleStatusVO::getLabels()[$model->getStatusCode()];
                    if($model->getStatusCode() != AppleStatusVO::STATUS_ON_THE_TREE) {
                        $result .= ' упало ' . Yii::$app->formatter->asDateTime($model->falledAt, 'dd.MM.YYYY (HH:mm)');
                    }
                    return $result;
                }
            ],
            [
                'label' => 'Целостность',
                'value' => function ($model)
                {
                    /* @var AppleEn $model */
                    return (100 - $model->eatenPercent) . ' %';
                }
            ],
            [
                'label' => 'Действия',
                'value' => function ($model)
                {
                    /* @var AppleEn $model */
                    /**
                     * TODO: Добавить действия
                     */
                    return '';
                },
                'format' => 'raw',
            ],
        ]
    ]) ?>
</div>
