<?php

namespace app\controllers;

use Yii;
use app\models\Country;
use app\models\CountrySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends Controller
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

            // todo: 注意为了可运行，user identity class 类必须 实现 findIdentityByAccessToken()方法。 认证方法过滤器通常在实现RESTful API中使用， 更多关于访问控制的详情请参阅 RESTful 认证 一节。
//                        'basicAuth' => [
//                            'class' => HttpBasicAuth::className(),
//                        ],

            // todo: HttpCache 利用 Last-Modified 和 Etag HTTP头实现客户端缓存。
            // 记录动作执行时间日志的过滤器。
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index', 'view'],
                // 'except' => ['create', 'delete'],
                'lastModified' => function ($action, $params) {
                    return time();
                    //                    $q = new \yii\db\Query();
                    //                    return $q->from('user')->max('updated_at');
                },
            ],

            // todo: AccessControl 提供基于 rules 规则的访问控制。 特别是在动作执行之前，访问控制会检测所有规则 并找到第一个符合上下文的变量（比如用户IP地址、登录状态等等）的规则， 来决定允许还是拒绝请求动作的执行
            //            'access' => [
            //                'class' => AccessControl::className(),
            //                'only' => ['create', 'update'],
            //                'rules' => [
            //                    // 允许认证用户
            //                    [
            //                        'allow' => true,
            //                        'roles' => ['@'],
            //                    ],
            //                    // 默认禁止其他用户
            //                ],
            //            ],
            // todo: AccessControl 提供基于 rules 规则的访问控制。 特别是在动作执行之前，访问控制会检测所有规则 并找到第一个符合上下文的变量（比如用户IP地址、登录状态等等）的规则， 来决定允许还是拒绝请求动作的执行
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup', 'about'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],

            // todo: ContentNegotiator ContentNegotiator支持响应内容格式处理和语言处理。 通过检查 GET 参数和 Accept HTTP头部来决定响应内容格式和语言。
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
                'languages' => [
                    'en-US',
                    'de',
                ],
            ],

        ];
    }

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sign = 10;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sign' => $sign,
        ]);
    }

    /**
     * Displays a single Country model.
     * @param string $id
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
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Country();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Country model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
     * 操作链接使用的单个删除
     */
    public function actionDeleteDemo(){
        $id=Yii::$app->request->get('id');
        $model = Attend::findOne($id);
        $model->delete();
        return $this->redirect(['attend/index']);
    }
    /*
     * 操作js使用的单个删除
     */
    public function actionDelete_js($id){
        try{
            $model = Attend::findOne($id);
            $model->delete();
            echo Json::encode(['done'=>true]);
        } catch (Exception $e) {
            echo Json::encode(['done'=>false,'error'=>$e->getMessage()]);
        }
    }
    /*
     * 多选删除js
     */
    public function actionDelete_all(){
        try{
            $ids=Yii::$app->request->post('ids');
            $ids=explode(',',$ids);
            //数组直接查询
            $lists = Attend::find()->where(['in','id',$ids])->all();
            foreach($lists as $list){
                $list->delete();
            }
            echo Json::encode(['done'=>true]);
        } catch (Exception $e) {
            echo Json::encode(['done'=>false,'error'=>$e->getMessage()]);
        }
    }
}
