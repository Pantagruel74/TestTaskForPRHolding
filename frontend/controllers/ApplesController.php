<?php

namespace frontend\controllers;

use backend\app\apples\ApplesServiceConfigurator;
use frontend\models\apples\BitForm;
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
                            'bit',
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
                            'bit',
                        ],
                        'allow' => false,
                        'roles' => [
                            '@', '?',
                        ],
                    ],
                    [
                        'actions' => [
                            'eat-form'
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

    /**
     * Главное представление с таблицей яблок и основным функционалом
     *
     * @return string
     */
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

    /**
     * Реинициализировать яблоки
     *
     * @return void
     */
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

    /**
     * Яблоко с указанным ID упало
     *
     * @return void
     */
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

    /**
     * Яболко с указанным ID прогнило
     *
     * @return void
     */
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

    /**
     * Удалить яблоко
     *
     * @return void
     */
    public function actionDelete()
    {
        try {
            $id = Yii::$app->request->get('id');
            if (empty($id)) {
                throw new \InvalidArgumentException('Не указан обязательный параметр ID');
            }
            $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
            $applesService->deleteOneById($id);
            Yii::$app->session->setFlash('success', 'Яблоко удалено');
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        $this->redirect('/apples/index');
    }

    public function actionEatForm()
    {
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
            throw new \InvalidArgumentException('Не указан обязательный параметр ID');
        }

        $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
        $appleEn = $applesService->getOneById($id);

        $bitForm = BitForm::createByAppleEn($appleEn);

        return $this->asJson([
            'html' => $this->renderPartial('_eat-form', [
                'bitForm' => $bitForm,
            ]),
        ]);
    }

    /**
     * Откусить яблоко
     *
     * @return void
     */
    public function actionBit()
    {
        try {
            $bitForm = new BitForm();
            if (!$bitForm->load(Yii::$app->request->post()) || !$bitForm->validate()) {
                throw new yii\base\ErrorException('Ошибка: ' . implode(', ', $bitForm->getFirstErrors()));
            }

            $applesService = ApplesServiceConfigurator::getDefaultInitializedByAr();
            $appleToDelete = $applesService->bitOneById($bitForm->id, $bitForm->bitPercent);

            if($appleToDelete) {
                Yii::$app->session->setFlash('warning', 'Яблоко полностью съедено');
            } else {
                Yii::$app->session->setFlash('success', 'Яблоко укушено');
            }
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        $this->redirect('/apples/index');
    }
}