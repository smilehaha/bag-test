<?php
namespace common\z;
use yii\web\Controller;
use yii;
class ZController extends Controller{
    /**
     * 站点名
     * @var string
     */
    public static $site_name = '大神蒜';
    public static $debug = '';
    /**
     * 初始化
     * @see \yii\base\Object::init()
     */
    public function init(){
        parent::init();
    }
    
    /**
     * 执行动作之前
     * @see \yii\base\Controller::beforeAction()
     */
    public function beforeAction($action){
        $operation = false;
        $operation = true;       
        return $operation ;
    }
    
    
}