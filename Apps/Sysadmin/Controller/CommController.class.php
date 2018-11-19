<?php
namespace Sysadmin\Controller;
use Think\Controller;
     
    class CommController extends Controller
    {
        
        
        public function _initialize()
        {
            if(!$this->is_admin_login())
            {
                $this->redirect('Sysadmin/Login/index','' , 0, '');
            }

        }
        //判断登录
        public function is_admin_login(){

            $cookie_check=cookie('admin_check');
            $admin_name=session('admin_name');
            $login_time=session('login_time');

            if(session('admin_name')=='' || session('admin_truename')==''){
                return false;
            }

            if($cookie_check=='' || $admin_name=='' || $login_time==''){
                return false;
            }else{
              
              if($cookie_check==MD5($admin_name.$login_time).MD5($login_time)){
                  return true;
              }else{
                  return false;
              }
            }
        }

        //验证管理员权限
        public function admin_purview()
        {

        }


        public function _empty()
        {
          header('HTTP/1.0 404 Not Found');
          echo'error:404';
          exit;
        }

}