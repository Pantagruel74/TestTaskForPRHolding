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

$this->title = 'Таблица яблок'
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
                    $result = '<div style="display: grid; grid-gap: 5px;">';
                    if ($model->getStatusCode() == AppleStatusVO::STATUS_ON_THE_TREE)
                    {
                        $result .= '<div>' . Html::button('Упасть', [
                            'class' => 'btn btn-info',
                            'style' => 'width: 100%',
                            'onclick' => "window.location.href = '/apples/fall?id=" . $model->id . "'",
                        ]) . '</div>';
                    } elseif ($model->getStatusCode() == AppleStatusVO::STATUS_ON_THE_GROUND)
                    {
                        $result .= '<div>' . Html::button('Прогнить', [
                            'class' => 'btn btn-info',
                            'style' => 'width: 100%',
                                'onclick' => "window.location.href = '/apples/rot?id=" . $model->id . "'",
                        ]) . '</div>';

                    }
                    $result .= '<div>' . Html::button('Откусить', [
                        'class' => 'btn btn-info',
                        'style' => 'width: 100%',
                        'onclick' => "window.location.href = '/apples/bit-from?id=" . $model->id . "'",
                    ]) . '</div>';
                    $result .= '<div>' . Html::button('Удалить', [
                        'class' => 'btn btn-danger',
                        'style' => 'width: 100%',
                        'onclick' => "window.location.href = '/apples/delete?id=" . $model->id . "'",
                    ]) . '</div>';
                    $result .= '</div>';
                    return $result;
                },
                'format' => 'raw',
            ],
        ]
    ]) ?>
</div>
