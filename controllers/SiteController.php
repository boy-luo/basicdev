<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\EntryForm;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        // todo:  Yii 提供了两套授权管理器： yii\rbac\PhpManager 和 yii\rbac\DbManager。前者使用 PHP 脚本存放授权数据， 而后者使用数据库存放授权数据。
        // todo:  Yii 提供了两套授权管理器： yii\rbac\PhpManager 和 yii\rbac\DbManager。前者使用 PHP 脚本存放授权数据， 而后者使用数据库存放授权数据。
        // todo: 使用 PhpManager  配置 RBAC  Yii 提供了两套授权管理器： yii\rbac\PhpManager 和 yii\rbac\DbManager。前者使用 PHP 脚本存放授权数据， 而后者使用数据库存放授权数据。
        // todo: 使用 PhpManager  配置 RBAC  Yii 提供了两套授权管理器： yii\rbac\PhpManager 和 yii\rbac\DbManager。前者使用 PHP 脚本存放授权数据， 而后者使用数据库存放授权数据。
        return [
            'access' => [
                'class' => AccessControl::className(),
                // todo: 这里改only
//                'only' => ['logout', 'entry'],
                'only' => ['logout', 'entry', 'special-callback'],
                'rules' => [
                    // todo: 授权 http://www.yiichina.com/doc/guide/2.0/security-authorization
                    // todo: 注意i只要一个满足就可以----- ACF 自顶向下逐一检查存取规则，直到找到一个与当前 欲执行的动作相符的规则。 然后该匹配规则中的 allow 选项的值用于判定该用户是否获得授权。
                    // todo: 注意i只要一个满足就可以----- ACF 自顶向下逐一检查存取规则，直到找到一个与当前 欲执行的动作相符的规则。 然后该匹配规则中的 allow 选项的值用于判定该用户是否获得授权。
                    // todo: 注意i只要一个满足就可以----- ACF 自顶向下逐一检查存取规则，直到找到一个与当前 欲执行的动作相符的规则。 然后该匹配规则中的 allow 选项的值用于判定该用户是否获得授权。
                    // todo: 以下一个数组为一条验证规则
                    // todo: 以下一个数组为一条验证规则
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        // todo: 这里面修改 各个方法分别的规则
                        'actions' => ['logout', 'entry'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['special-callback'],
                        'allow' => true,
//                        'roles' => ['@'],
//                        'roles' => ['?'],
//                        'ips' => ['192.168.*'],
//                        'ips' => ['192.168.3.199'],
//                        'ips' => ['192.168.3.*'],
                        // verbs：指定该规则用于匹配哪种请求方法（例如GET，POST
//                        'verbs'=>['POST'],
                        'verbs'=>['GET'],
                        'matchCallback' => function ($rule, $action) {
//                            return date('d-m') === '31-10';
                            var_dump(date('d-m'));
                            exit();
                            return date('d-m') === '19-04';
                        }
                        /**

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

                            当这个规则不满足条件时该函数会被调用。（译者注：此处的回调函数是匿名函数）

                         * */
                    ],
//                    [
//                        'actions' => ['entry'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionEntry()
    {
        // 当前用户的身份实例。未认证用户则为 Null 。
        $identity = Yii::$app->user->identity;
        var_dump($identity);

        // 当前用户的ID。 未认证用户则为 Null 。
        $id = Yii::$app->user->id;
        var_dump($id);

        // 判断当前用户是否是游客（未认证的）
        $isGuest = Yii::$app->user->isGuest;
        var_dump($isGuest);


        $model = new EntryForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据

            // 做些有意义的事 ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // 无论是初始化显示还是数据验证错误
            return $this->render('entry', ['model' => $model]);
        }
    }

    public function actionTest()
    {

        $test = \Yii::$app->componentID;
        var_dump($test);
        echo '---------';

        $test = \Yii::$app->db;
        var_dump($test);


        echo $userHost = Yii::$app->request->userHost;
        echo '<br>';
        echo $userIP = Yii::$app->request->userIP;
        echo '<br>';
        echo '<br>';
        // $headers 是一个 yii\web\HeaderCollection 对象
        $headers = Yii::$app->request->headers;

        // 返回 Accept header 值
        echo $accept = $headers->get('Accept');

        if ($headers->has('User-Agent')) { /* 这是一个 User-Agent 头 */ }
        echo '<br>';
        echo $headers->has('User-Agent');

        echo '<br>';
        echo '<br>';

        $request = Yii::$app->request;

        $get = $request->get();

        $post = $request->post();
        if ($request->isAjax) { /* 该请求是一个 AJAX 请求 */ }
        if ($request->isGet)  { /* 请求方法是 GET */ }
        if ($request->isPost) { /* 请求方法是 POST */ }
        if ($request->isPut)  { /* 请求方法是 PUT */ }


        // 主页URL：/index.php?r=site%2Findex
        echo Url::home();
        echo '<br>';

        // 根URL，如果程序部署到一个Web目录下的子目录时非常有用
        echo Url::base();
        echo '<br>';

        // 当前请求的权威规范URL
        // 参考 https://en.wikipedia.org/wiki/Canonical_link_element
        echo Url::canonical();
        echo '<br>';

        // 记住当前请求的URL并在以后获取
        Url::remember();
        echo Url::previous();
        echo '<br>';
        echo Url::previous();
        echo '<br>';
        echo Url::previous();


    }

    public function actionSess()
    {
        $session = Yii::$app->session;

        // 检查session是否开启
        if ($session->isActive) {
            echo '已经开启了的';

        } else {
            echo '暂时没有开启';
        }
        echo '<br>';

        // 开启session
        $session->open();

        // 获取session中的变量值，以下用法是相同的：
        echo $language = $session->get('language');
        echo '<br>';
        echo $language = $session['language'];
        echo '<br>';
        echo $language = isset($_SESSION['language']) ? $_SESSION['language'] : null;
        echo '<br>';

        // 设置一个session变量，以下用法是相同的：
        $session->set('language', 'en-US');
        $session['language'] = 'en-US';
        $_SESSION['language'] = 'en-US';

        // 关闭session
        $session->close();

        // 销毁session中所有已注册的数据
        $session->destroy();
    }


    public function actionResp()
    {
        $headers = Yii::$app->response->headers;

        // 增加一个 Pragma 头，已存在的Pragma 头不会被覆盖。
        $headers->add('Pragma', 'no-cache');

        // 设置一个Pragma 头. 任何已存在的Pragma 头都会被丢弃
        $headers->set('Pragma', 'no-cache');

        // 删除Pragma 头并返回删除的Pragma 头的值到数组
        $values = $headers->remove('Pragma');
        var_dump($values);

        Yii::$app->response->content = 'hello world!';
        $response = Yii::$app->response;
//        $response->format = \yii\web\Response::FORMAT_JSON;
//        HTML: 通过 yii\web\HtmlResponseFormatter 来实现.
//    XML: 通过 yii\web\XmlResponseFormatter来实现.
//    JSON: 通过 yii\web\JsonResponseFormatter来实现.
//    JSONP: 通过 yii\web\JsonResponseFormatter来实现.
//    RAW: use this format if you want to send the response directly without applying any formatting.
        $response->data = ['message' => 'hello world'];

        $response->format = \yii\web\Response::FORMAT_HTML;
        $response->data = "Yii支持以下可直接使用的格式，每个实现了formatter 类， 可自定义这些格式器或通过配置yii\web\Response:: 属性来增加格式器。";

        //
//        // todo: 成功
//        Yii::$app->response->statusCode = 220;
//        // todo: 成功
//        //        throw new \yii\web\NotFoundHttpException;
//        throw new \yii\web\ConflictHttpException;

    }

    public function actionJson()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        return [
//            'message' => 'hello world',
//            'code' => 100,
//        ];

        // todo: 除了使用默认的 response 应用组件，也可创建自己的响应对象并发送给终端用户
        return \Yii::createObject([
                                      'class' => 'yii\web\Response',
                                      'format' => \yii\web\Response::FORMAT_JSON,
                                      'data' => [
                                          'message' => 'hello world createObject',
                                          'code' => 100,
                                      ],
                                  ]);
    }
    public function actionDownload()
    {
        // todo: ok
//        return \Yii::$app->response->sendFile('../sendfile.txt');

        // todo: 上面的标准些  这里输出内容是没有的  应该是结束了的
        \Yii::$app->response->sendFile('../sendfile.txt');
        echo '12';
        return;
    }

    public function actionOld()
    {
//        return $this->redirect('http://example.com/new', 301);

        // todo:
        echo '还能输出吗  能';
        // exit;
        \Yii::$app->response->redirect('http://example.com/new', 301)->send();
        echo '还能输出吗  不能了';
        exit;
    }

    // 匹配的回调函数被调用了！这个页面只有每年的10月31号能访问（译者注：原文在这里说该方法是回调函数不确切，读者不要和 `matchCallback` 的值即匿名的回调函数混淆理解）。
    public function actionSpecialCallback()
    {

        var_dump(11666);
//        return $this->render('happy-halloween');
    }

    public function actionOffline()
    {
        var_dump('offline catch all.');
//        return $this->render('happy-halloween');
    }

    function function_name($event) {
        echo $event->data;
    }
}
