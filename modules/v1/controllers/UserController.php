<?php

namespace app\modules\v1\controllers;

use app\base\rest\Controller;
use app\models\User;
use yii\web\NotFoundHttpException;

/**
 * Контроллер пользователя
 */
class UserController extends Controller
{
    /** @var string $modelClass */
    public $modelClass = 'app\models\User';

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return \yii\helpers\ArrayHelper::merge(
            parent::actions(),
            [
                'index'   => null,
                'view'    => null,
                'create'  => null,
                'update'  => null,
                'delete'  => null,
                'options' => null,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'bearerAuth' => [
                'class' => \yii\filters\auth\HttpBearerAuth::className(),
            ],
        ];
    }

    /**
     * Действие добавления записи
     */
    public function actionCreate() {
        $model = new $this->modelClass;
        
        $data = \Yii::$app->request->getBodyParams();
        if (isset($data['password'])) {
            $data['password_hash'] = $data['password'];
            unset($data['password']);
        }
        $model->load($data, '');
        if ($model->save()) {
            \Yii::$app->response->statusCode = 201;
            return $model->getAttributes(['id', 'username', 'email']);
        }

        \Yii::$app->response->statusCode = 422;
        return $model->getErrors();
    }

    /**
     * Действие вывода полей записи
     */
    public function actionView($id) {
        $model = User::find()
            ->andWhere([
                'id' => $id,
                'status' => 10,
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('в БД нет такого id с статусом 10');
        }

        return $model->getAttributes(['id', 'username', 'email']);
    }

    /**
     * Действие обновление данных записи
     */
    public function actionUpdate($id) {
        $model = User::find()
            ->andWhere([
                'id' => $id,
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('в БД нет такого id');
        }

        $fieldsToUpdate = ['username', 'email', 'password'];

        $data = array_filter(
            \Yii::$app->request->getBodyParams(),
            function ($key) use ($fieldsToUpdate) {
                return in_array($key, $fieldsToUpdate);
            },
            ARRAY_FILTER_USE_KEY
        );
        if (isset($data['password'])) {
            $data['password_hash'] = $data['password'];
            unset($data['password']);
        }
        $model->load($data, '');

        if ($model->save()) {
            \Yii::$app->response->statusCode = 201;
            return $model->getAttributes(['id', 'username', 'email']);
        }

        \Yii::$app->response->statusCode = 422;
        return $model->getErrors();
    }
    
    /**
     * Действие удаления записи
     */
    public function actionDelete($id) {
        $model = User::find()
            ->andWhere([
                'id' => $id,
                'status' => 10,
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('в БД нет такого id');
        }

        $model->status = 0;
        if ($model->save()) {
            \Yii::$app->response->statusCode = 204;
        }

        return [];
    }
}