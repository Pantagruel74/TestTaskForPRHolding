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
                            'fall',
                            'rot',
                            'delete',
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
                            'fall',
                            'rot',
                            'delete',
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
        try {
            $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
            $applesService->resetAppleByRandomNum();
            Yii::$app->session->setFlash('success', 'Реинициализация прошла успешно!');
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('danger', 'Ошибка при попытке реинициализации');
        }

        $this->redirect('/apples/index');
    }

    public function actionFall()
    {
        try {
            $id = Yii::$app->request->get('id');
            if (empty($id)) {
                throw new \InvalidArgumentException('Не указан обязательный параметр ID');
            }
            $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
            $applesService->fallOneById($id);
            Yii::$app->session->setFlash('success', 'Яблоко упало');
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        $this->redirect('/apples/index');
    }

    public function actionRot()
    {
        try {
            $id = Yii::$app->request->get('id');
            if (empty($id)) {
                throw new \InvalidArgumentException('Не указан обязательный параметр ID');
            }
            $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
            $applesService->rotOneById($id);
            Yii::$app->session->setFlash('success', 'Яблоко сгнило');
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        $this->redirect('/apples/index');
    }
}