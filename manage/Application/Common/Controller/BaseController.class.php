<?php

namespace Common\Controller;

use Think\Controller;
use Common\Model\AuthRuleModel;
 



class BaseController extends Controller{
	
	
	/**
	 * 后台控制器初始化
	 */
	protected function _initialize(){
		// 获取当前用户ID
		define('UID',is_admin_login());
		if( !UID ){// 还没登录 跳转到登录页面
			$this->redirect('Member/Login/login');
		}
		/* 读取数据库中的配置 */
		$config =   S('DB_CONFIG_DATA');
		if(!$config){
			$config =   api('SystemConfig/lists');
			S('DB_CONFIG_DATA',$config);
		}
		C($config); //添加配置
	
	
		// 是否是超级管理员
		define('IS_ROOT',   is_administrator());
		if(!IS_ROOT && C('ADMIN_ALLOW_IP')){
			// 检查IP地址访问
			if(!in_array(get_client_ip(),explode(',',C('ADMIN_ALLOW_IP')))){
				$this->error('403:禁止访问');
			}
		}
// 		// 检测访问权限
// 		$access =   $this->accessControl();
// 		if ( $access === false ) {
// 			$this->error('403:禁止访问');
// 		}elseif( $access === null ){
// 			$dynamic        =   $this->checkDynamic();//检测分类栏目有关的各项动态权限
// 			if( $dynamic === null ){
// 				//检测非动态权限
// 				$rule  = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
// 				if ( !$this->checkRule($rule,array('in','1,2')) ){
// 					$this->error('未授权访问!');
// 				}
// 			}elseif( $dynamic === false ){
// 				$this->error('未授权访问!');
// 			}
// 		}
		$this->assign('__UID__', UID);
 
	}
	
	/**
	 * 权限检测
	 * @param string  $rule    检测的规则
	 * @param string  $mode    check模式
	 * @return boolean
	 * @author Rocks
	 */
	final protected function checkRule($rule, $type=AuthRuleModel::RULE_URL, $mode='url'){
		if(IS_ROOT){
			return true;//管理员允许访问任何页面
		}
		static $Auth    =   null;
		if (!$Auth) {
			$Auth       =   new \Think\Auth();
		}
		if(!$Auth->check($rule,UID,$type,$mode)){
			return false;
		}
		return true;
	}
	
	/**
	 * 检测是否是需要动态判断的权限
	 * @return boolean|null
	 *      返回true则表示当前访问有权限
	 *      返回false则表示当前访问无权限
	 *      返回null，则会进入checkRule根据节点授权判断权限
	 *
	 * @author Rocks
	 */
	protected function checkDynamic(){
		if(IS_ROOT){
			return true;//管理员允许访问任何页面
		}
		return null;//不明,需checkRule
	}
	
	
	/**
	 * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
	 *
	 * @return boolean|null  返回值必须使用 `===` 进行判断
	 *
	 *   返回 **false**, 不允许任何人访问(超管除外)
	 *   返回 **true**, 允许任何管理员访问,无需执行节点权限检测
	 *   返回 **null**, 需要继续执行节点权限检测决定是否允许访问
	 * @author Rocks
	 */
	final protected function accessControl(){
		if(IS_ROOT){
			return true;//管理员允许访问任何页面
		}
		$allow = C('ALLOW_VISIT');
		$deny  = C('DENY_VISIT');
		$check = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
		if ( !empty($deny)  && in_array_case($check,$deny) ) {
			return false;//非超管禁止访问deny中的方法
		}
		if ( !empty($allow) && in_array_case($check,$allow) ) {
			return true;
		}
		return null;//需要检测节点权限
	}
	
	/**
	 * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
	 *
	 * @param string $model 模型名称,供M函数使用的参数
	 * @param array  $data  修改的数据
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 */
	final protected function editRow ( $model ,$data, $where , $msg ){
		$id    = array_unique((array)I('id',0));
		$id    = is_array($id) ? implode(',',$id) : $id;
		//$where = array_merge( array('id' => array('in', $id )) ,(array)$where );
		$msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
		if(is_string($model)){
			$model  =   M($model);
		}
		if( $model->where($where)->save($data)!==false ) {
			$this->success($msg['success'],$msg['url'],$msg['ajax']);
		}else{
			$this->error($msg['error'],$msg['url'],$msg['ajax']);
		}
	}
	
	/**
	 * 禁用条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的 where()方法的参数
	 * @param array  $msg   执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author Rocks
	 */
	protected function forbid ( $model , $where = array() , $msg = array( 'success'=>'状态禁用成功！', 'error'=>'状态禁用失败！')){
		$data    =  array('status' => 0);
		$this->editRow( $model , $data, $where, $msg);
	}
	
	/**
	 * 恢复条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author Rocks
	 */
	protected function resume (  $model , $where = array() , $msg = array( 'success'=>'状态恢复成功！', 'error'=>'状态恢复失败！')){
		$data    =  array('status' => 1);
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	/**
	 * 还原条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 * @author Rocks
	 */
	protected function restore (  $model , $where = array() , $msg = array( 'success'=>'状态还原成功！', 'error'=>'状态还原失败！')){
		$data    = array('status' => 1);
		$where   = array_merge(array('status' => -1),$where);
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	/**
	 * 条目假删除
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author Rocks
	 */
	protected function delete ( $model , $where = array() , $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！')) {
		$data['status']         =   -1;
		$data['update_time']    =   NOW_TIME;
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	/**
	 * 设置一条或者多条数据的状态
	 */
	public function setStatus($Model=CONTROLLER_NAME){
	
		$ids    =   I('request.ids');
		$status =   I('request.status');
		if(empty($ids)){
			$this->error('请选择要操作的数据');
		}
	
		$map['id'] = array('in',$ids);
		switch ($status){
			case -1 :
				$this->delete($Model, $map, array('success'=>'删除成功','error'=>'删除失败'));
				break;
			case 0  :
				$this->forbid($Model, $map, array('success'=>'禁用成功','error'=>'禁用失败'));
				break;
			case 1  :
				$this->resume($Model, $map, array('success'=>'启用成功','error'=>'启用失败'));
				break;
			default :
				$this->error('参数错误');
				break;
		}
	}
  
	
	
	/**
	 * 通用分页列表数据集获取方法
	 *
	 *  可以通过url参数传递where条件,例如:  userList.html?name=asdfasdfasdfddds
	 *  可以通过url空值排序字段和方式,例如: userList.html?_field=id&_order=asc
	 *  可以通过url参数r指定每页数据条数,例如: userList.html?r=5
	 *
	 * @param sting|Model  $model   模型名或模型实例
	 * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
	 * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
	 *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
	 *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
	 *
	 * @param array        $base    基本的查询条件
	 * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
	 * @author Rocks
	 *
	 * @return array|false
	 * 返回数据集
	 */
	protected function lists ($model,$where=array(),$order='',$base = array('status'=>array('egt',0)),$field=true){
		$options    =   array();
		$REQUEST    =   (array)I('request.');
		if(is_string($model)){
			$model  =   M($model);
		}
	
		$OPT        =   new \ReflectionProperty($model,'options');
		$OPT->setAccessible(true);
	
		$pk         =   $model->getPk();
		if($order===null){
			//order置空
		}else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
			$options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
		}elseif( $order==='' && empty($options['order']) && !empty($pk) ){
			$options['order'] = $pk.' desc';
		}elseif($order){
			$options['order'] = $order;
		}
		unset($REQUEST['_order'],$REQUEST['_field']);
	
		$options['where'] = array_filter(array_merge( (array)$base, /*$REQUEST,*/ (array)$where ),function($val){
			if($val===''||$val===null){
				return false;
			}else{
				return true;
			}
		});
		if( empty($options['where'])){
			unset($options['where']);
		}
		$options      =   array_merge( (array)$OPT->getValue($model), $options );
		$total        =   $model->where($options['where'])->count();
	
		if( isset($REQUEST['r']) ){
			$listRows = (int)$REQUEST['r'];
		}else{
			$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
		}
		$page = new \Think\Page($total, $listRows, $REQUEST);
		if($total>$listRows){
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		}
		$p =$page->show();
		$this->assign('_page', $p? $p: '');
		$this->assign('_total',$total);
		$options['limit'] = $page->firstRow.','.$page->listRows;
	
		$model->setProperty('options',$options);
	
		return $model->field($field)->select();
	}
	

	public   function  getUserGroups()
	{
		$fields=array('id','group_name');
		$groups = M('UserGroup')->field($fields)->select();
		return $groups;
	}
	
	public   function  getGames()
	{
		$fields=array('id','pid','name','title','sort');
		$map['pid']=array('gt',0);
		$games = M('SystemGame')->field($fields)->where($map)->select();
		return $games;
	}
	
	public   function  getCategories()
	{
		$fields=array('id','category_name');
		$categories = M('VideoCategory')->field($fields)->select();
		return $categories;
	}
	
	
	public   function  getcountries()
	{
		$fields=array('id','country_name');
		$countries = M('SystemCountry')->field($fields)->select();
		return $countries;
	}
	
}

?>