<?php

namespace app\models;

use yii\base\InvalidParamException;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            // strcasecmp — 二进制安全比较字符串（不区分大小写）
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }


    // todo: 当速率限制被激活，默认情况下每个响应将包含以下 HTTP 头发送目前的速率限制信息：
    // todo: 当速率限制被激活，默认情况下每个响应将包含以下 HTTP 头发送目前的速率限制信息：
    // todo: 当速率限制被激活，默认情况下每个响应将包含以下 HTTP 头发送目前的速率限制信息：
    /**
    getRateLimit(): 返回允许的请求的最大数目及时间，例如，[100, 600] 表示在 600 秒内最多 100 次的 API 调用。
    loadAllowance(): 返回剩余的允许的请求和最后一次速率限制检查时 相应的 UNIX 时间戳数。
    saveAllowance(): 保存剩余的允许请求数和当前的 UNIX 时间戳。
     */
//    public function getRateLimit($request, $action)
//    {
//        return [1, 3]; // $rateLimit requests per second
////        return [100, 600]; // $rateLimit requests per second
////        return [$this->rateLimit, 1]; // $rateLimit requests per second
//    }

//    public function loadAllowance($request, $action)
//    {
//        return [$this->allowance, $this->allowance_updated_at];
//    }
//
//    public function saveAllowance($request, $action, $allowance, $timestamp)
//    {
//        $this->allowance = $allowance;
//        $this->allowance_updated_at = $timestamp;
//        $this->save();
//    }
//
//    // 3.添加角色和权限
//    // a.创建权限
//    public function createPermission($name)
//    {
//        $auth = Yii::$app->authManager;
//        $createPost = $auth->createPermission($name);
//        $createPost->description = '创建了 ' . $name. ' 权限';
//        $auth->add($createPost);
//    }
//
//    // b.创建角色
//    public function createRole($name)
//    {
//        $auth = Yii::$app->authManager;
//        $role = $auth->createRole($name);
//        $role->description = '创建了 ' . $name. ' 角色';
//        $auth->add($role);
//    }
//
//    // 以上两条添加，会创auth_item表中创建两条记录，以表中的type类型作为区分，type=1是角色，type=2为权限
//    public function add($object)
//    {
//        if ($object instanceof Item) {
//            return $this->addItem($object);
//        } elseif ($object instanceof Rule) {
//            return $this->addRule($object);
//        } else {
//            throw new InvalidParamException("Adding unsupported object type.");
//        }
//    }
//
//    // add方法会根据你传入的对象属性进行添加（添加角色和权限都是addItem,因为createPermission和createRole都创建了一个Item对象，只是对象中的type值不同）
//    // 4.添加用户、角色和权限之间的关系
//    // a.将权限赋给角色
//    public function addChild($items)
//    {
//        $auth = Yii::$app->authManager;
//        $parent = $auth->createRole($items['role']);                //创建角色对象
//        $child = $auth->createPermission($items['permission']);     //创建权限对象
//        $auth->addChild($parent, $child);                           //添加对应关系
//    }
//    // 注意：上面创建的角色和权限对象，必须已经在数据库中创建，比如items['role'] = test,否则会报错
//    // b.将角色赋给用户
////    public function addChild($items)
////    {
////        $auth = Yii::$app->authManager;
////        $role = $auth->createRole($items['role']);                //创建角色对象
////        $user_id = 1;                                             //获取用户id，此处假设用户id=1
////        $auth->assign($role, $user_id);                           //添加对应关系
////    }
//
//    // 5.验证权限
//    public function beforeAction($action)
//    {
//        $action = Yii::$app->controller->action->id;
//        if(\Yii::$app->user->can($action)){
//            return true;
//        }else{
//            throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
//        }
//    }
//
//    // 看下\Yii::$app->user->can()这个方法
//    public function can($permissionName, $params = [], $allowCaching = true)
//    {
//        if ($allowCaching && empty($params) && isset($this->_access[$permissionName])) {
//            return $this->_access[$permissionName];
//        }
//        $access = $this->getAuthManager()->checkAccess($this->getId(), $permissionName, $params);
//        if ($allowCaching && empty($params)) {
//            $this->_access[$permissionName] = $access;
//        }
//
//        return $access;
//    }
}
