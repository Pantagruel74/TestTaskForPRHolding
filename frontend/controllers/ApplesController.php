<?php

namespace frontend\controllers;

use backend\app\apples\ApplesServiceConfigurator;
use yii\helpers\Url;
use yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ApplesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'reinit',
                        ],
                        'allow' => true,
                        'roles' => [
                            'user'
                        ],
                    ],
                    [
                        'actions' => [
                            'index',
                            'reinit',
                        ],
                        'allow' => false,
                        'roles' => [
                            '@', '?',
                        ],
                    ],
                    [
                        'actions' => [
                        ],
                        'allow' => true,
                        'roles' => [
                            '@', '?',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
        $applesDataProvider = new yii\data\ArrayDataProvider([
            'allModels' => $applesService->getAll(),
        ]);

        return $this->render('index', [
            'applesDataProvider' => $applesDataProvider,
        ]);
    }

    public function actionReinit()
    {
        $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
        $applesService->resetAppleByRandomNum();

        $this->redirect('/apples/index');
    }
}