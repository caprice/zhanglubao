<?php
namespace Home\Controller;
use User\Api\UserApi;
require_once APP_PATH . 'User/Conf/config.php';



class UserController extends BaseController
{
	public function  login($email='',$password='')
	{
		if (IS_POST)
		{
			$user = new UserApi;
			$uid = $user->login($email, $password,2);
			if (0 < $uid) {
				$Member = D('Member');
				if ($Member->login($uid,$remember=='on')) { //登录用户
					$this->success('登录成功！', U('/index'));
				} else {
					$this->error($Member->getError());
				}

			} else {
				switch ($uid) {
					case -1:
						$error = '用户不存在或被禁用！';
						break;
					case -2:
						$error = '密码错误！';
						break;
					default:
						$error = '未知错误27！';
						break;
				}
				$this->error($error);
			}

		}else
		{
			if (is_login()) {
				redirect(U('/index'));
			}
			$this->display();
		}

	}
	public function  reg($username = '', $password = '', $repassword = '', $email = '')
	{
		if (IS_POST)
		{
			if ($password != $repassword) {
				$this->error('密码和重复密码不一致！');
			}

			$User = new UserApi;
			$uid = $User->register($username, $password, $email);
			if (0 < $uid) {
				$uid = $User->login($username, $password);
				if (0<$uid)
				{
					$Member = D('Member');
					if ($Member->login($uid,$remember=='on')) {
						$this->success('注册成功！', U('/user/info'));
					} else {
						$this->error($Member->getError());
					}
				}else
				{

					switch ($uid) {
						case -1:
							$error = '用户不存在或被禁用！';
							break;
						case -2:
							$error = '密码错误！';
							break;
						default:
							$error = '未知错误27！';
							break;
					}
					$this->error($error);

				}
				$this->success('成功注册,正在转入登录页面！', U('/user/info'));
			} else {
				$this->error($this->showRegError($uid));
			}


		}else
		{
			if (is_login()) {
				redirect(U('index'));
			}
			$this->display();
		}
	}

	public  function  info()
	{
			
		if (IS_POST)
		{
			$return  = array('status' => 1, 'info' => '更新成功', 'data' => '');
			$data['uid']=get_uid();
			$data['sex']=I('sex');
			$data['province']=I('province');
			$data['city']=I('city');
			$data['area']=I('area');
			$data['location']=I('location');
			$data['signature']=trim(I('signature'));
			$data['birthday']=strtotime(I('birthday'));
			$data['mobile']=trim(I('mobile'));
			$Member=D('Member');
			if ($Member->save($data))
			{
				$return['url']=U('/user/avatar');

			}else
			{
				$return['status']=0;
				$return['info']='更新失败';
			}
			$this->ajaxReturn($return);

		}else
		{
			if (!is_login())
			{
				redirect(U('/index'));
			}
			$this->display();
		}

	}

	public  function  avatar()
	{
		if (IS_POST)
		{
			$return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
			$Avatar = D('Avatar');
			$pic_driver = C('PICTURE_UPLOAD_DRIVER');
			$info = $Avatar->upload(
			$_FILES,
			C('AVATAR_PICTURE_UPLOAD'),
			C('PICTURE_UPLOAD_DRIVER'),
			C("UPLOAD_{$pic_driver}_CONFIG")
			);

			if(isset($info)){
				$return['status'] = 1;
				$return['url']=U('/index');
				$return = array_merge($info['Filedata'], $return);
			} else {
				$return['status'] = 0;
				$return['info']   = $Avatar->getError();
			}
			clean_query_user_cache(get_uid(),'avatar');
			 $this->ajaxReturn($return);
		}else
		{
			if (!is_login())
			{
				redirect(U('/index'));
			}
			$this->display();
		}
	}




	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0)
	{
		switch ($code) {
			case -1:
				$error = '用户名长度必须在16个字符以内！';
				break;
			case -2:
				$error = '用户名被禁止注册！';
				break;
			case -3:
				$error = '用户名被占用！';
				break;
			case -4:
				$error = '密码长度必须在6-30个字符之间！';
				break;
			case -5:
				$error = '邮箱格式不正确！';
				break;
			case -6:
				$error = '邮箱长度必须在1-32个字符之间！';
				break;
			case -7:
				$error = '邮箱被禁止注册！';
				break;
			case -8:
				$error = '邮箱被占用！';
				break;
			case -9:
				$error = '手机格式不正确！';
				break;
			case -10:
				$error = '手机被禁止注册！';
				break;
			case -11:
				$error = '手机号被占用！';
				break;
			default:
				$error = '未知错误24';
		}
		return $error;
	}
	
    /* 退出登录 */
    public function logout()
    {
        if (is_login()) {
            D('Member')->logout();
            $this->success('退出成功！', U('/user/login'));
        } else {
            $this->redirect('/user/login');
        }
    }
}