<?php

namespace frontend\controllers;

use Yii;
use common\models\HomeworkFinished;
use common\models\HomeworkFinishedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Homework;
use common\models\User;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use frontend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * HomeworkFinishedController implements the CRUD actions for HomeworkFinished model.
 */
class HomeworkFinishedController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
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
     * Lists HomeworkFinished models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HomeworkFinishedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!empty(Yii::$app->request->get()['HomeworkFinishedSearch']['homework_id'])) {
            $homework = Homework::findOne(Yii::$app->request->get()['HomeworkFinishedSearch']['homework_id']);
        }else {
            $homework = null;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'homework' => $homework,
        ]);
    }

    /**
     * 展示一篇作品
     * 连同其附加文件
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($model->user_id);
        $homework = Homework::findOne($model->homework_id);
        $model->view_times ++;
        $model->save();

        $upload = null;

        if ($model->user_id == Yii::$app->user->id) {
            $upload = new UploadForm();
            if (Yii::$app->request->isPost) {
                $upload->file = UploadedFile::getInstance($upload, 'file');
                if ($upload->upload($model, $homework, $user)) {
                    Yii::$app->session->setFlash('success', '恭喜，文件已上传！');
                }
            }
        }

        return $this->render('view', [
            'model' => $model,
            'user' => $user,
            'homework' => $homework,
            'upload' => $upload,
        ]);
    }

    /**
     * Creates a new HomeworkFinished model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($homework_id)
    {
        if (!User::isRealNameAuthenticated()) {
            Yii::$app->session->setFlash('warning', '做作业之前建议你告诉我们你真实的姓名，这将展示于你的作品中哦。');
            return $this->redirect('/user/index');
        }

        if (HomeworkFinished::findOne([
            'homework_id' => $homework_id,
            'user_id' => Yii::$app->user->id,
            'status' => HomeworkFinished::STATUS_ACTIVE,
        ])) {
            Yii::$app->session->setFlash('warning', '本次作业你已完成！可以修改哦～');
            return $this->redirect(['index', 'HomeworkFinishedSearch[homework_id]' => $homework_id]);
            //throw new BadRequestHttpException('本次作业你已完成！可以修改哦～');
        }

        $model = new HomeworkFinished();
        $homework = Homework::findOne($homework_id);
        if ($model->selfLoad(Yii::$app->request->post())) {
            $model->homework_id = $homework_id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '恭喜！你已完成本次杰作！强烈建议你上传代码文件可供同学们下载浏览！');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderPartial('edit', [
            'model' => $model,
            'homework' => $homework,
        ]);
    }

    /**
     * Updates an existing HomeworkFinished model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws BadRequestHttpException 如果权限不够
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id != Yii::$app->user->id) {
            throw new BadRequestHttpException('你被拒绝！');
        }

        if ($model->selfLoad(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '恭喜，修改成功！');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $homework = Homework::findOne($model->homework_id);

        return $this->renderPartial('edit', [
            'model' => $model,
            'homework' => $homework,
        ]);
    }

    /**
     * Deletes an existing HomeworkFinished model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws BadRequestHttpException 如果权限不够
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id != Yii::$app->user->id) {
            throw new BadRequestHttpException('你被拒绝！');
        }

        if ($model->moveToTrash()) {
            Yii::$app->session->setFlash('success', '删除成功！');
        }

        return $this->redirect(['index']);
    }

    /**
     * 文件下载
     *
     * @param HomeworkFinished ID
     * @return download file
     */
    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        $model->file_download_times ++;
        $model->save();

        return Yii::$app->response->sendFile($model->file);
    }

    /**
     * Finds the HomeworkFinished model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HomeworkFinished the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HomeworkFinished::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
