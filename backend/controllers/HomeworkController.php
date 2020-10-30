<?php

namespace backend\controllers;

use Yii;
use common\models\Homework;
use common\models\HomeworkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\UploadHomeworkImageForm;
use yii\web\UploadedFile;

/**
 * HomeworkController implements the CRUD actions for Homework model.
 */
class HomeworkController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

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
        $uploadHomeworkImageForm = new UploadHomeworkImageForm();
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $uploadHomeworkImageForm->imageFile = UploadedFile::getInstance($uploadHomeworkImageForm, 'imageFile');
            if ($uploadHomeworkImageForm->upload($model)) {
                Yii::$app->session->setFlash('success', '恭喜，作业图片已上传！');
            }
        }
        return $this->render('view', [
            'model' => $model,
            'uploadHomeworkImageForm' => $uploadHomeworkImageForm,
        ]);
    }

    /**
     * Creates a new Homework model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Homework();
        $model->created_at = date("Y-m-d H:i:s");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Homework model.
     * If update is successful, the browser will be redirected to the 'view' page.
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
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Homework model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 文件下载
     *
     * @param Homework ID
     * @return download file
     */
    public function actionDownload($id)
    {
        $model = $this->findModel($id);

        return Yii::$app->response->sendFile($model->image);
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

        throw new NotFoundHttpException('未找到本次作业！');
    }
}
