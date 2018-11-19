<?php
namespace Fwapi\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
       echo 'api';
       exit;
    }
    public function _empty()
    {
      header('HTTP/1.0 404 Not Found');
      echo'error:404';
      exit;
    }
}