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

// todo: 如果你系那个支持以上3个认证方式，可以使用CompositeAuth，如下所示：
use yii\filters\auth\CompositeAuth;
// use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;


/**
 * CountryController implements the CRUD actions for Country model.
 */
class ApiController extends Controller
{
    // todo: Tip：如果你将RESTful APIs作为应用开发，可以设置应用配置中 user 组件的 enableSession， 如果将RESTful APIs作为模块开发，可以在模块的 init() 方法中增加如下代码，如下所示：
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => HttpBasicAuth::className(),
//        ];
//        return $behaviors;

        // todo: 如果你系那个支持以上3个认证方式，可以使用CompositeAuth，如下所示：
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;

    }

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        return 'test api';
    }

}
