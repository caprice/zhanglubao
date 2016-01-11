<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-9
 * Time: 上午8:59
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Usercenter\Widget;
use Think\Action;

/**input类型输入渲染
 * Class InputWidget
 * @package Usercenter\Widget
 * @郑钟良
 */
class InputRenderWidget extends Action {

    public function inputRender($data=array(),$type){
        //dump($data);exit;
        $this->assign('type',$type);
        $this->assign('field_id',$data['id']);
        $this->assign('required',$data['required']);
        $this->assign('input_tips',$data['input_tips']);
        if(!isset($data['field_content'])&&$data['required']&&$data['form_default_value']==''){
            $this->assign('canSubmit',0);
        }elseif(isset($data['field_content']['field_data'])&&$data['field_content']['field_data']==''&&$data['required']){
            $this->assign('canSubmit',0);
        }else{
            $this->assign('canSubmit',1);
        }
        switch($data['form_type']){
            case 'input':
                $this->assign('field_name',$data['field_name']);
                $this->assign('child_form_type',$data['child_form_type']);
                $validation=$this->_getValidation($data['validation']);
                $this->assign('validation',$validation);
                if(!$data['field_content']){
                    $this->assign('field_data',$data['form_default_value']);
                }else{
                    $this->assign('field_data',$data['field_content']['field_data']);
                }
                $this->display('Widget/input_template');
                break;
            case 'radio':
                $this->assign('field_name',$data['field_name']);
                $checked=isset($data['field_content']['field_data'])?$data['field_content']['field_data']:"还未选择";
                if($type=="personal"){
                    if($data['form_default_value']!=''&&$data['form_default_value']!=null){
                        $canCheck=explode('|',$data['form_default_value']);
                        $items=array();
                        foreach($canCheck as $key=>$val){
                            $items[$key]['value']=$val;
                            $items[$key]['checked']=($checked==$val)?'checked':'';
                        }
                        if(!isset($data['field_content']['field_data'])){
                            $items[0]['checked']='checked';
                        }
                    }
                }

                $this->assign('items',$items);
                $this->assign('checked',$checked);
                $this->display('Widget/radio_template');
                break;
            case 'checkbox':
                $this->assign('field_name',$data['field_name']);
                if($type=="personal"){
                    if($data['form_default_value']!=''&&$data['form_default_value']!=null){
                        $canCheck=explode('|',$data['form_default_value']);
                        $items=null;
                        if(!$data['field_content']){
                            foreach($canCheck as $key=>$val){
                                if($val!=''){
                                    $items[$key]['value']=$val;
                                    $items[$key]['selected']=0;
                                }
                            }
                        }else{
                            $checked=explode('|',$data['field_content']['field_data']);
                            foreach($canCheck as $key=>$val){
                                if($val!=''){
                                    $items[$key]['value']=$val;
                                    if(in_array($val,$checked)){
                                        $items[$key]['selected']=1;
                                    }else{
                                        $items[$key]['selected']=0;
                                    }
                                }
                            }
                        }
                        $this->assign('items',$items);
                    }
                }else{
                    $checked=explode('|',$data['field_content']['field_data']);
                    $this->assign('checked',$checked);
                }
                $this->display('Widget/checkbox_template');
                break;
            case 'select':
                $this->assign('field_name',$data['field_name']);
                $selected=isset($data['field_content']['field_data'])?$data['field_content']['field_data']:"还未选择";
                if($type=="personal"){
                    if($data['form_default_value']!=''&&$data['form_default_value']!=null){
                        $canSelected=explode('|',$data['form_default_value']);
                        $items=array();
                        foreach($canSelected as $key=>$val){
                            $items[$key]['value']=$val;
                            $items[$key]['selected']=($selected==$val)?'selected':'';
                        }
                        if(!isset($data['field_content']['field_data'])){
                            $items[0]['selected']='selected';
                        }
                    }else{
                        $canSelected[0]['value']='无';
                        $canSelected[0]['selected']='selected';
                    }
                }

                $this->assign('items',$items);
                $this->assign('selected',$selected);
                $this->display('Widget/select_template');
                break;
            case 'time':
                $this->assign('field_name',$data['field_name']);

                if(!$data['field_content']){
                    $this->assign('field_data',null);
                }else{
                    $data['field_content']['field_data']=date("Y-m-d",$data['field_content']['field_data']);
                    $this->assign('field_data',$data['field_content']['field_data']);
                }
                $this->display('Widget/time_template');
                break;
            case 'textarea':
                $this->assign('field_name',$data['field_name']);
                $validation=$this->_getValidation($data['validation']);
                $this->assign('validation',$validation);
                if(!$data['field_content']){
                    $this->assign('field_data',$data['form_default_value']);
                }else{
                    $this->assign('field_data',$data['field_content']['field_data']);
                }
                $this->display('Widget/textarea_template');
                break;
            }
    }
    function _getValidation($validation){
        $data['min']=$data['max']=0;
        if($validation!=''){
            $items=explode('&',$validation);
            foreach($items as $val){
                $item=explode('=',$val);
                if($item[0]=='min'&&is_numeric($item[1])&&$item[1]>0){
                    $data['min']=$item[1];
                }
                if($item[0]=='max'&&is_numeric($item[1])&&$item[1]>0){
                    $data['max']=$item[1];
                }
            }
        }
        return $data;
    }

} 