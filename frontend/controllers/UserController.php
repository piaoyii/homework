<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * 已登陆用户账户设置
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 用户主页
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel(Yii::$app->user->id);
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * 更新用户资料
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = date("Y-m-d H:i:s");
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '恭喜，你已更新信息！');
                return $this->redirect('index');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('未找到这个页面！');
    }
}
