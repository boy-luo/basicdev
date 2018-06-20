<?php

use yii\db\Migration;

/**
 * 命令行执行
 * PS D:\WWW\basicdev> ./yii migrate/create init_rbac
Yii Migration Tool (based on Yii v2.0.16-dev)

Create new migration 'D:\WWW\basicdev/migrations\m180516_091102_init_rbac.php'? (yes|no) [no]:yes
New migration created successfully.
PS D:\WWW\basicdev>
 *
 * Class m180516_091102_init_rbac
 */
class m180516_091102_init_rbac extends Migration
{
    /**
     * // todo: 在 up() 方法中编写改变数据库结构的代码。 你可能还需要在 down() 方法中编写代码来恢复由 up() 方法所做的改变。 当你通过 migration 升级数据库时， up() 方法将会被调用，反之， down() 将会被调用。
     */
    public function up()
    {
        $auth = Yii::$app->authManager;

        // 添加 "createPost" 权限
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // 添加 "updatePost" 权限
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // 添加 "author" 角色并赋予 "createPost" 权限
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // 添加 "admin" 角色并赋予 "updatePost"
        // 和 "author" 权限
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // 为用户指派角色。其中 1 和 2 是由 IdentityInterface::getId() 返回的id
        // 通常在你的 User 模型中实现这个函数。
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}