<?php

namespace frontend\controllers;

use Yii;
use common\models\Homework;
use common\models\HomeworkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * HomeworkController implements the R actions for Homework model.
 */
class HomeworkController extends Controller
{
    /**
     * Lists all Homework models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HomeworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Homework model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Homework model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Homework the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Homework::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('没有找到本次作业！');
    }
}
