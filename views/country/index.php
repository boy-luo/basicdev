<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\Url;
// use yii\helpers\Html;
//use common\helps\Helps;
//use common\helps\ArrayHelper;
//// use yii\grid\GridView;
//use backend\models\User;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Countries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Country', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
                             //默认layout的表格三部分可不写：几条简介，表格，分页；可以去掉任意部分
                             //'layout' => "{summary}\n{items}\n{pager}" ,
                             //没有数据时候显示的内容和html样式
                             'emptyText'=>'当前没有内容',
                             'emptyTextOptions'=>['style'=>'color:red;font-weight:bold'],
                             //给所有的行属性增加id，或class，方便后面选择后整行改变颜色
                             'rowOptions'=>function($model){
//                                 return ['id'=>"tr-".$model->id];
                                 return ['id'=>"tr-"];
                             },
                             //显示底部（就是多了一栏），默认是关闭的
                             'showFooter'=>true,

        'columns' => [
            //ActionColumn 显示操作按钮等CheckboxColumn 显示复选框RadioButtonColumn 显示单选框SerialColumn 显示行号
            [
                'class' => 'yii\grid\CheckboxColumn',
                //'cssClass'=>'_check',//不能用？？？？后面有js实现的
                //底部第一列占6格，其他列隐藏，形成合并1个单元格效果
                 'footerOptions'=>['colspan'=>6],
//                'footerOptions'=>['colspan'=>4],
                'footer'=>'<a href="javascript:;" class="_delete_all" data-url="'.Yii::$app->urlManager->createUrl(['/attend/delete_all']).'">删除全部</a>',

            ],

            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'code',
                'label' => 'Code',
                'enableSorting'=>false,
//                'value' => $model->code,
                'value' => function ($model) {
                    return $model->code ? $model->code : 'have no';
                    //                                        return $model->eventTrigger['processedTime'];
                },
                //如果sign=1不显示此列，否则显示
                'visible'=>$sign==1 ? false : true,
                //'value'=>function($data){
                //    return date('Y-m-d H:i:s',$data->create_time);
                //}
                // todo: 这里会在底部多一个列  不显示就不会多这一列  会影响底部和并列的显示
                'footerOptions'=>['class'=>'hide'],
            ],
            [
                'attribute' => 'code',
                'label' => 'Code',
                // 'enableSorting'=>false,
//                'value' => $model->code,
                'value' => function ($model) {
                    return $model->code ? $model->code : 'have no';
                    //                                        return $model->eventTrigger['processedTime'];
                },
                'format' => 'raw', //显示label样式，否则显示html代码
                'footerOptions'=>['class'=>'hide'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                //控制
                "header" => "操作 自定义标题 宽度",
                'headerOptions' => ['width' => '300'],
                'template'=>'{get} {yes} {no} {update} {delete}',
                //下面buttons可以不写delete函数，delete默认调用当前控制器下面的delete方法
                "buttons" => [
                    "delete"=>function ($url, $model, $key) {//print_r($key);exit;
                        return "<a href='javascript:;' class='_delete' data-url='".Yii::$app->urlManager->createUrl(['/attend/delete_js','id'=>$model->code])."'>删除</a>";
                    },
                    "update"=>function ($url, $model, $key) {//print_r($key);exit;
                        //$model 为当前的1条数据
                        //key就是id
                        //$url就是根据id自动拼出链接 /attend/update?id=156
                        $str='';
                        $str=Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['attend/edit','id'=>$model->code]), ['title'=>'修改']);
                        return $str;
                    },
                ],
                'footerOptions'=>['class'=>'hide'],
            ],
            [
                'attribute' => 'code',
                'label' => 'Code',
                'enableSorting'=>false,
//                'value' => $model->code,
                'value' => function ($model) {
                    return $model->code ? $model->code : 'have no';
                    //                                        return $model->eventTrigger['processedTime'];
                },
            ],

            'code',
            'name',
            'population',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


<script>
    $("input[name='selection[]']").addClass("_check");
    //选中改变颜色
    $("._check").click(function(){
        var id=$(this).val();
        console.log(id);
        if($("#tr-"+id).hasClass("select_bg")){
            $("#tr-"+id).removeClass("select_bg");
        }else{
            //$("#tr-"+id).css("background-color",'red');
            $("#tr-"+id).addClass("select_bg");
        }
    });
    $("._delete").click(function(){
        var url=$(this).attr('data-url');
        console.log(url);
        $.getJSON(url,{},function(d){
            if(d.done==true){
                alert('删除成功');
                window.location.href="<?=Url::to(['attend/index'])?>";
            }else{
                alert(d.error);
            }
        });
    });
    $("._delete_all").click(function(){
        var many_check=$("input[name='selection[]']:checked");
        var ids="";
        $(many_check).each(function(){
            ids+=this.value+',';
        });
        //去掉最后一个逗号
        if (ids.length > 0) {
            ids = ids.substr(0, ids.length - 1);
        }else{
            alert('请选择至少一条记录！'); return false;
        }
        var url=$(this).attr('data-url');
        $.post(url,{ids},function(d){
            console.log(d);
            if(d.done==true){
                console.log(1);
                alert('删除成功！');
                window.location.href="<?=Url::to(['attend/index'])?>";
            }else{
                alert(d.error);
            }
        },'json');
    });
</script>