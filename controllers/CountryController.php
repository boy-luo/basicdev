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

use yii\filters\PageCache;
use yii\caching\DbDependency;

use yii\filters\Cors;
use yii\helpers\ArrayHelper;

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
                    'index'  => ['get'],
                    'view'   => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'put', 'post'],
                    'delete' => ['post', 'delete'],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],

            // todo: 注意为了可运行，user identity class 类必须 实现 findIdentityByAccessToken()方法。 认证方法过滤器通常在实现RESTful API中使用， 更多关于访问控制的详情请参阅 RESTful 认证 一节。
//                        'basicAuth' => [
//                            'class' => HttpBasicAuth::className(),
//                        ],

            // todo: HttpCache 利用 Last-Modified 和 Etag HTTP头实现客户端缓存。
            // todo: 成功
            // todo: 成功
            // 记录动作执行时间日志的过滤器。
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index', 'view'],
                // 'except' => ['create', 'delete'],
                'lastModified' => function ($action, $params) {
                    // todo: 它会基于页面最后修改时间生成一个 Last-Modified HTTP 头。 当浏览器第一次访问 index 页时，服务器将会生成页面并发送至客户端浏览器。 之后客户端浏览器在页面没被修改期间访问该页， 服务器将不会重新生成页面，浏览器会使用之前客户端缓存下来的内容。 因此服务端渲染和内容传输都将省去。 --- 所以需要返回一个固定时间表示最后修改时间
//                    return '2018-05-16 08:06:47';
                    // todo: 成功   304 not modified   需要返回时间戳
                    // todo: 成功   304 not modified   需要返回时间戳
                    // todo: 成功   304 not modified   需要返回时间戳
                     return 1526458007;
                    // return time()-1000;
                    // todo: 下面的函數就实现根据内容变动而动态缓存--实现高效
                    //                    $q = new \yii\db\Query();
                    //                    return $q->from('user')->max('updated_at');
                },
            ],

            // todo: “Entity Tag”（实体标签，简称 ETag）使用一个哈希值表示页面内容。如果页面被修改过， 哈希值也会随之改变。通过对比客户端的哈希值和服务器端生成的哈希值， 浏览器就能判断页面是否被修改过，进而决定是否应该重新传输内容。 -----类似用内容生成随机值 --可能有存储匹配
            // todo: 复杂的 Etag 生成种子可能会违背使用 HttpCache 的初衷而引起不必要的性能开销， 因为响应每一次请求都需要重新计算 Etag。 请试着找出一个最简单的表达式去触发 Etag 失效。
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['view'],
                'etagSeed' => function ($action, $params) {
                    // $post = $this->findModel(\Yii::$app->request->get('id'));
                    // W/"PWTFb18CZcyRkiy295GwU+RoXCY"
                    return serialize(['test2 modified', 'test']);
                    // W/"rnnDa9KUqxwKuC5X+bH7Iu80Fno"
                    return serialize(['test modified', 'test']);
                    // return serialize([$post->title, $post->content]);
                },
            ],
            /**
             *
             *  todo: Cache-Control 头
Cache-Control 头指定了页面的常规缓存策略。 可以通过配置 yii\filters\HttpCache::$cacheControlHeader 属性发送相应的头信息。默认发送以下头：

Cache-Control: public, max-age=3600
会话缓存限制器
当页面使 session 时，PHP 将会按照 PHP.INI 中所设置的 session.cache_limiter 值自动发送一些缓存相关的 HTTP 头。 这些 HTTP 头有可能会干扰你原本设置的 HttpCache 或让其失效。 为了避免此问题，默认情况下 HttpCache 禁止自动发送这些头。 想改变这一行为，可以配置 yii\filters\HttpCache::$sessionCacheLimiter 属性。 该属性接受一个字符串值，包括 public，private，private_no_expire，和 nocache。 请参考 PHP 手册中的缓存限制器
    */

            // todo: PageCache 实现服务器端整个页面的缓存。如下示例所示，PageCache应用在 index 动作， 缓存整个页面 60 秒或 post 表的记录数发生变化
            // todo: PageCache 实现服务器端整个页面的缓存。如下示例所示，PageCache应用在 index 动作， 缓存整个页面 60 秒或 post 表的记录数发生变化
            // todo:  注意 页面缓存指的是在服务器端缓存整个页面的内容。
            //// todo: 页面缓存指的是在服务器端缓存整个页面的内容。
            /// // todo: 位置成功与否 ---缓存在服务器端
            /// // todo: 位置成功与否 ---缓存在服务器端
//            'pageCache' => [
//                'class' => PageCache::className(),
//                'only' => ['index'],
//                'duration' => 60,
//                'dependency' => [
//                    'class' => DbDependency::className(),
//                    'sql' => 'SELECT COUNT(*) FROM country',
//                    // 'sql' => 'SELECT COUNT(*) FROM post',
//                ],
//                'variations' => [
//                    \Yii::$app->language,
//                ]
//            ],

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
            /**
            Access rules 支持很多的选项。下列是所支持选项的总览。 你可以派生 yii\filters\AccessRule 来创建自定义的存取规则类。
                allow： 指定该规则是 "允许" 还是 "拒绝" 。（译者注：true是允许，false是拒绝）

                actions：指定该规则用于匹配哪些动作。 它的值应该是动作方法的ID数组。匹配比较是大小写敏感的。如果该选项为空，或者不使用该选项， 意味着当前规则适用于所有的动作。

                controllers：指定该规则用于匹配哪些控制器。 它的值应为控制器ID数组。匹配比较是大小写敏感的。如果该选项为空，或者不使用该选项， 则意味着当前规则适用于所有的动作。（译者注：这个选项一般是在控制器的自定义父类中使用才有意义）

                roles：指定该规则用于匹配哪些用户角色。 系统自带两个特殊的角色，通过 yii\web\User::isGuest 来判断：

                ?： 用于匹配访客用户 （未经认证）
                @： 用于匹配已认证用户
                使用其他角色名时，将触发调用 yii\web\User::can()，这时要求 RBAC 的支持 （在下一节中阐述）。 如果该选项为空或者不使用该选项，意味着该规则适用于所有角色。

                yii\filters\AccessRule::roleParams：指定将传递给 yii\web\User::can() 的参数。 请参阅下面描述RBAC规则的部分，了解如何使用它。 如果此选项为空或未设置，则不传递任何参数。

                ips：指定该规则用于匹配哪些 yii\web\Request::userIP 。 IP 地址可在其末尾包含通配符 * 以匹配一批前缀相同的IP地址。 例如，192.168.* 匹配所有 192.168. 段的IP地址。 如果该选项为空或者不使用该选项，意味着该规则适用于所有角色。

                verbs：指定该规则用于匹配哪种请求方法（例如GET，POST）。 这里的匹配大小写不敏感。

                matchCallback：指定一个PHP回调函数用于 判定该规则是否满足条件。（译者注：此处的回调函数是匿名函数）
             */
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['login', 'logout', 'signup', 'about'],
                'only' => ['login', 'logout', 'signup', 'about', 'special-callback'],
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
                    [
                        'allow' => true,
                        'actions' => ['special-callback'],
                        // ???????
                        // 'verbs' => ['post'],
                        // todo:  放到这里的
                        // todo: 成功之后调用下面的 actionSpecialCallback ????
                        // todo: 成功
                        // todo: 成功
                        // todo: 成功
                        'matchCallback' => function ($rule, $action) {
                            return date('d-m') === '16-05';
                            return false;
                            return date('d-m') === '31-10';
                        }
                    ],
                ],
            ],

            // todo: 跨域资源共享 CORS 机制允许一个网页的许多资源（例如字体、JavaScript等） 这些资源可以通过其他域名访问获取。 特别是 JavaScript 的 AJAX 调用可使用 XMLHttpRequest 机制， 由于同源安全策略该跨域请求会被网页浏览器禁止. CORS定义浏览器和服务器交互时哪些跨域请求允许和禁止。
            // todo: Cors filter 应在 授权 / 认证 过滤器之前定义， 以保证CORS头部被发送。
            /**
             * CROS过滤器可以通过 $cors 属性进行调整。

            cors['Origin']：定义允许来源的数组，可为 ['*']（任何用户）或 ['http://www.myserver.net', 'http://www.myotherserver.com']。 默认为 ['*']。
            cors['Access-Control-Request-Method']：允许动作数组如 ['GET', 'OPTIONS', 'HEAD']。默认为 ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS']。
            cors['Access-Control-Request-Headers']：允许请求头部数组，可为 ['*'] 所有类型头部 或 ['X-Request-With'] 指定类型头部。默认为 ['*']。
            cors['Access-Control-Allow-Credentials']：定义当前请求是否使用证书，可为 true, false 或 null (不设置). 默认为 null。
            cors['Access-Control-Max-Age']: 定义请求的有效时间，默认为 86400。
            */
//            [
//                'class' => Cors::className(),
//            ],
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ],
                'actions' => [
                    'index' => [
                        'Access-Control-Allow-Credentials' => true,
                    ]
                ]
            ],

//            // 认证失败调用方法
//            'denyCallback' => function ($rule, $action) {
//                return ' no  ok';
//                throw new \Exception('You are not allowed to access this page 我的');
//            }

            // todo: ContentNegotiator ContentNegotiator支持响应内容格式处理和语言处理。 通过检查 GET 参数和 Accept HTTP头部来决定响应内容格式和语言。
//            [
//                'class' => ContentNegotiator::className(),
//                'formats' => [
//                    'application/json' => Response::FORMAT_JSON,
//                    'application/xml' => Response::FORMAT_XML,
//                ],
//                'languages' => [
//                    'en-US',
//                    'de',
//                ],
//            ],

            // todo: 当速率限制被激活，默认情况下每个响应将包含以下 HTTP 头发送目前的速率限制信息：
            // todo: 当速率限制被激活，默认情况下每个响应将包含以下 HTTP 头发送目前的速率限制信息：
            // todo: 当速率限制被激活，默认情况下每个响应将包含以下 HTTP 头发送目前的速率限制信息：
            // todo: 失败
            // todo: 失败 限流 (Rate Limiting) ¶  http://www.yiichina.com/doc/guide/2.0/rest-rate-limiting
            // todo: 失败 限流 (Rate Limiting) ¶  http://www.yiichina.com/doc/guide/2.0/rest-rate-limiting
            // 'rateLimiter' => ['enableRateLimitHeaders' => false],

        ];


        //        return ArrayHelper::merge([
        //                                      [
        //                                          'class' => Cors::className(),
        //                                          'cors' => [
        //                                              'Origin' => ['*'],
        //                                              'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
        //                                              'Access-Control-Request-Headers' => ['*'],
        //                                              'Access-Control-Allow-Credentials' => null,
        //                                              'Access-Control-Max-Age' => 86400,
        //                                              'Access-Control-Expose-Headers' => [],
        //                                          ],
        //                                          'actions' => [
        //                                              'index' => [
        //                                                  'Access-Control-Allow-Credentials' => true,
        //                                              ]
        //                                          ]
        //                                      ],
        //                                  ], parent::behaviors());


    }

    // todo: 匹配的回调函数被调用了！这个页面只有每年的10月31号能访问（译者注：原文在这里说该方法是回调函数不确切，读者不要和 `matchCallback` 的值即匿名的回调函数混淆理解）。
    // todo: 匹配的回调函数被调用了！这个页面只有每年的10月31号能访问（译者注：原文在这里说该方法是回调函数不确切，读者不要和 `matchCallback` 的值即匿名的回调函数混淆理解）。
    // todo: 匹配的回调函数被调用了！这个页面只有每年的10月31号能访问（译者注：原文在这里说该方法是回调函数不确切，读者不要和 `matchCallback` 的值即匿名的回调函数混淆理解）。
    public function actionSpecialCallback()
    {
        // todo: 成功
        // todo: 成功
        var_dump('是访问这个方法,, 上面匹配成功才能正常访问。');
        exit();
        return $this->render('happy-halloween');
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
