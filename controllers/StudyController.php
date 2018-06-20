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

class StudyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // todo: 这里改only
//                'only' => ['logout', 'entry'],
                'only' => ['logout', 'entry', 'special-callback'],
                'rules' => [
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
     * 获取已经有的 属性
     * @return string
     */
    public function actionProperty()
    {

        // yii\base\Application::id
        // todo:
         // var_dump(yii\base\Application::id);
         $this->id;
         var_dump($this->id);

        // yii\base\Application::aliases

        // var_dump($this->basePath);
        // yii\base\Application::basePath
        // todo:
        // var_dump(yii\base\Application::basePath);

        // Yii::$app->request->headers;
        // var_dump(Yii::$app->request->headers);


        // $headers 是一个 yii\web\HeaderCollection 对象
        $headers = Yii::$app->request->headers;
        // todo:
        // var_dump($headers);

        // 返回 Accept header 值
        $accept = $headers->get('Accept');
        var_dump($accept);

        if ($headers->has('User-Agent')) {
            /* 这是一个 User-Agent 头 */
            echo ' 这是一个 User-Agent 头';
            echo '<br>';
        } else {
            echo ' 这个沒有 User-Agent 头';
            echo '<br>';

        }

        $userHost = Yii::$app->request->userHost;
        var_dump($userHost);
        $userIP = Yii::$app->request->userIP;
        var_dump($userIP);

        //yii\web\Request::url：返回 /admin/index.php/product?id=100, 此URL不包括host info部分。
        //yii\web\Request::absoluteUrl：返回 http://example.com/admin/index.php/product?id=100, 包含host infode的整个URL。
        //yii\web\Request::hostInfo：返回 http://example.com, 只有host info部分。
        //yii\web\Request::pathInfo：返回 /product， 这个是入口脚本之后，问号之前（查询字符串）的部分。
        //yii\web\Request::queryString：返回 id=100,问号之后的部分。
        //yii\web\Request::baseUrl：返回 /admin, host info之后， 入口脚本之前的部分。
        //yii\web\Request::scriptUrl：返回 /admin/index.php, 没有path info和查询字符串部分。
        //yii\web\Request::serverName：返回 example.com, URL中的host name。
        //yii\web\Request::serverPort：返回 80, 这是web服务中使用的端口。

        $request = Yii::$app->request;
        if ($request->isAjax) {
            /* 该请求是一个 AJAX 请求 */
            echo '该请求是一个 AJAX 请求';
            echo '<br>';
        } else {
            echo '不是，该请求是一个 AJAX 请求';
            echo '<br>';
        }
        if ($request->isGet)  {
            /* 请求方法是 GET */
            echo '请求方法是 GET';
            echo '<br>';
        } else {
            echo '不是，请求方法是 GET';
            echo '<br>';
        }
        if ($request->isPost) {
            /* 请求方法是 POST */
            echo '请求方法是 POST';
            echo '<br>';
        } else {
            echo '不是，请求方法是 POST';
            echo '<br>';
        }
        if ($request->isPut)  {
            /* 请求方法是 PUT */
            echo '请求方法是 PUT';
            echo '<br>';
        } else {
            echo '不是，请求方法是 PUT';
            echo '<br>';
        }

        // return $this->render('index');
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
