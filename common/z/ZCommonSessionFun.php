<?php
namespace common\z;
use yii;
use common\models\OauthBind;

class ZCommonSessionFun
{
    /**
     * 前台用户登录url
     * @var unknown
     */
    const urlLoginUserStr = 'login/login';
    /**
     * 用户主页
     * @var unknown
     */
    const urlIndexUserStr = 'survey/index';
    /**
     * 个人中心
     * @var unknown
     */
    const urlMyStr = 'survey/my';
    /**
     * 用户session前缀
     * @var unknown
     */
    public static $user_session_prefix = 'user';
    /**
     * 获取session全名
     * @param string $name
     * @return string
     */
    public static function getSessionName($name){
        return self::$user_session_prefix.'_'.$name;
    }
    /**
     * 设置session
     *
     * @param string $name            
     * @param unknown $value            
     * @return number
     */
    public static function set_session($name, $value)
    {
        if (empty($name)) {
            return false;
        }
        $name = self::getSessionName($name);
        Yii::$app->session[$name] = $value;
        
        return true;
    }

    /**
     * 获取session
     *
     * @param unknown $name            
     * @return unknown
     */
    public static function get_session($name)
    {
        if (empty($name)) {
            return null;
        }
 
        $name = self::getSessionName($name);
     
        return isset(Yii::$app->session[$name]) ? Yii::$app->session[$name] : null;
    }
    
    /**
     * 设置用户session
     *
     * @param unknown $value
     * @return unknown
     */
    public static function set_user_session($value) {
       return self::set_session('user', $value);
    }
     
    /**
     * 获取用户 session
     */
    public static function get_user_session() {
        return self::get_session('user');
    }
    
    
    
    /**
     * 获取角色id
     */
    public static function get_role(){
        $user = self::get_user_session();
        if( isset($user['role']) ){
            return $user['role'] != 0 ?  $user['role'] : 0;
        }
        return 0;
    }
    /**
     * 获取登录类型账号登陆还是第三方登录
     */
    public static function get_login_type(){
        $user = self::get_user_session();
        $user['login_type'] = isset($user['login_type']) ? $user['login_type'] : '';
        $user['login_type_text'] = isset($user['login_type_text']) ? $user['login_type_text'] : '';
        self::set_user_session($user);
        return $user;
    }
    /**
     * 设置账号登录还是第三方登录
     * @param string $type OauthBind::constBindList() 返回数组键
     * @return boolean
     */
    public static function set_login_type($type){
        $user = self::get_user_session();
        $bindList = OauthBind::constBindList();
        if( isset($bindList[$type]) ){
            $user['login_type'] = $type;
            $user['login_type_text'] = $bindList[$type];
            return true;
        }
        return false;
    }
     
    /**
     * 获取用户id
     * @return id
     */
    public static function get_user_id(){
        $uid = 0;
        $user = self::get_user_session();
        
        if ( isset($user['uid']) ) {
            $uid = $user['uid'];
            $uid = $uid>0 ? $uid :0 ;
            
        }
//         ZCommonFun::print_r_debug($user);
//         echo $uid;
        return $uid;
    }
    /**
     * 清空session
     */
    public static function session_clear(){
       Yii::$app->session->destroy();
    }
    /**
     * 获取session id
     */
    public static function session_id(){
        return Yii::$app->session->getId();
    }
    /**
     * 重新生成session id
     * @param string $old_sessionid
     */
    public static function session_id_regenerate($old_sessionid=false){
        Yii::$app->session->regenerateID($old_sessionid);
    }
    /**
     * 获取当前脚本
     * @return Ambigous <NULL, string>
     */
    public static function get_base_url(){
        $base_url = null;
        if($base_url===null){
            $base_url = dirname(Yii::$app->urlManager->hostInfo.Yii::$app->urlManager->scriptUrl);
        }
        return $base_url;
    }
    
    
   
    
}
