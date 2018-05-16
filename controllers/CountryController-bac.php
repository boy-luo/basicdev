<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Country;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;

class bac extends Controller
{
    /**
     * 过滤器限制
     * // todo:  注意 是behaviors  不是 before,  before是 beforeAction action 不是 havior
     *
     * @return array
     */
    public function behaviors()
    {
        return [
//            'basicAuth' => [
//                'class' => HttpBasicAuth::className(),
//            ],
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index', 'view'],
                // 'except' => ['create', 'delete'],
                'lastModified' => function ($action, $params) {
                    return time()-1000;
//                    $q = new \yii\db\Query();
//                    return $q->from('user')->max('updated_at');
                },
            ],
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
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
        ];
    }

    public function actionIndex()
    {
        $query = Country::find();

        $pagination = new Pagination([
                                         'defaultPageSize' => 5,
                                         // 'pageSizeLimit' => 8, //  什么作用??
                                         'totalCount' => $query->count(),
                                     ]);
/*
to to
 * */
        var_dump($pagination);
        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
    }

    /**
     * 过滤器限制
     *
     * @return string
     */
    public function actionFilter()
    {
    }
}