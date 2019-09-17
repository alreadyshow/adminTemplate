<?php

namespace backend\controllers;

use http\Exception\UnexpectedValueException;
use Yii;
use common\models\TSBankAgentCode;
use backend\models\TSBankAgentCodeSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BankAgentCodeController implements the CRUD actions for TSBankAgentCode model.
 */
class BankAgentCodeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TSBankAgentCode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TSBankAgentCodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetData()
    {
        if (Yii::$app->request->isAjax) {
            $page = Yii::$app->request->get('page', '');
            $limit = Yii::$app->request->get('limit', '');

            $dataProvider = TSBankAgentCode::find();
            if ($page || $limit) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return Yii::$app->response->data = [
                    'code' => 0,
                    'msg' => '请求成功！',
                    'count' => $dataProvider->count(),
                    'data' => $dataProvider->limit($limit)->offset(($page - 1) * $limit)->asArray()->all()
                ];
            }
        }
    }

    /**
     * Displays a single TSBankAgentCode model.
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
     * Creates a new TSBankAgentCode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TSBankAgentCode();
        $model->bank_code = 0;
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                Yii::$app->session->setFlash('warning', $model->getErrorSummary(1)[0]);
                return $this->redirect('index');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TSBankAgentCode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TSBankAgentCode model.
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
     * Finds the TSBankAgentCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TSBankAgentCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TSBankAgentCode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('norm', 'The requested page does not exist.'));
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->post('id',false);
        $bank_code = Yii::$app->request->post('bank_code',false);
        if (false === $id) {
            throw new NotFoundHttpException(Yii::t('norm', '缺少参数id'));
        }

        $model = TSBankAgentCode::findOne(['id' => $id]);
        $model->bank_code = $bank_code;
        if (!$model->save()) {
            throw new UnexpectedValueException(Yii::t('norm', '数据错误！'));
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'data' => 'success',
            'code' => 1001,
        ];
    }
}
