<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\HelperHealthSignIn;
use common\models\User;
use yii\web\NotFoundHttpException;

/**
 * 助手
 */
class HelperController extends Controller
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
     * 助手主页
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 健康打卡助手
     *
     * @return mixed
     */
    public function actionHealthSignIn()
    {
        $model = HelperHealthSignIn::findOne(['user_id' => Yii::$app->user->id]);
        $isNew = false;
        if ($model == null) {
            $model = new HelperHealthSignIn();
            $model->user_id = Yii::$app->user->id;
            $model->is_open = HelperHealthSignIn::IS_OPEN_YES;
            $model->callback_token = Yii::$app->getSecurity()->generateRandomString(HelperHealthSignIn::CALLBACK_TOKEN_LENGTH);
            $isNew = true;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->is_open == HelperHealthSignIn::IS_OPEN_YES) {
                if ($isNew) {
                    Yii::$app->session->setFlash('success', '恭喜！你已成功开启打卡助手！');
                } else {
                    Yii::$app->session->setFlash('success', '修改成功！');
                }
            } else {
                Yii::$app->session->setFlash('success', '关闭成功！你将不会收到任何的通知！');
            }
        }

        return $this->render('health-sign-in',[
            'model' => $model,
        ]);
    }

    /**
     * 健康打卡助手
     * 回调通知
     *
     * @param string $token
     * @return mixed
     */
    public function actionHealthSignInCallback($token)
    {
        $helperHealthSignIn = HelperHealthSignIn::findOne(['callback_token' => $token]);
        if (empty($helperHealthSignIn)) {
            throw new NotFoundHttpException('未知的 token 。');
        }
        $helperHealthSignIn->status = HelperHealthSignIn::STATUS_OK;
        $helperHealthSignIn->save();

        return '谢谢你，我已获悉。';
    }
}
