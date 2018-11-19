<?php
namespace Klapi\Controller;
use Think\Controller;
class IndexController extends BaseApiController{
	private $params;
	protected $ImagePath;
	public function __construct($params = null)
	{
		//$this->_initialize(); //tp5.0
		parent::__construct($params); //tp3.2
		$this->params=$params;
		//var_dump($this->params);
		//$this->ImagePath=$this->request->domain().'/Kangli/Public/uploads/product/';
	}
    public function index(){
    	// echo '百邦码：'.WEBSITE;
	    // exit;
	    isset($this->params["init"]) ? $init = $this->params["init"] : $init = ''; //代表查询的初始条件
	    //获取公告信息：
	    $hbData = $this->getHaiBao();
	    $ggData = $this->getGongGao();
	    $ssData = $this->getShopShow();

	    $headerArr=$this->request['header'];
	    if (isset($headerArr['token'])){
	      if ($headerArr['token']=='true'||$headerArr['token']=='True'||$headerArr['token']=='TRUE'||$headerArr['token']===true)
	      {
	          $unitcodeStr=$headerArr['unitcode'];
	          if (is_not_null($unitcodeStr))
	          {
	            $ttamp=$headerArr['ttamp'];
	            $unitcode=$this->aes->decrypt($unitcodeStr);
	            $unit_code_time=mb_substr($unitcode,0,mb_strlen($ttamp),'utf-8');
	            $unit_code=mb_substr($unitcode,mb_strlen($ttamp),mb_strlen($unitcode)-mb_strlen($ttamp),'utf-8');
	            if ($ttamp!=$unit_code_time)
	            $this->err_get(2);
	            if ($unit_code!=$this->qy_unitcode)
	            $this->err_get(3);
	            $token=$this->api_unit_token_get();
	          }else
	          {
	            $this->err_get(3);
	          }
	          return array(
	          "haibao" => $hbData,
	          "gonggao" => $ggData,
	          "shopshow" => $ssData,
	          "token" =>$token
	          );
	      }
	    }
	    return array(
	      "haibao" => $hbData,
	      "gonggao" => $ggData,
	      "shopshow" => $ssData
	    );
    }

	/**
	* getHaiBao 获取首页海报数据
	* @return [type] [description]
	*/
	public function getHaiBao()
	{
	//公告
	  $map=array();
	  $map['ad_unitcode']=$this->qy_unitcode;
	  $haibao=M('Adinfo')->where($map)->field('ad_id,ad_name,ad_pic')->order('ad_addtime DESC')->select();
	  // foreach ($haibao as $k => $v) {
	  //   $haibao[$k]['ad_pic']=IMGHOST.$v['ad_pic'];
	  //   # code...
	  // }
	 return $haibao;
	}

	/**
	* getGongGao 获取首页公告数据
	* @return [type] [description]
	*/
	public function getGongGao()
	{
		//公告
	    $map=array();
	  $map['news_isgg']=1;
	  $map['news_unitcode']=$this->qy_unitcode;
	  $gonggao=M('Jfmonews')->where($map)->field('news_id,news_title')->order('news_addtime DESC')->select();
	  if($gonggao){
	        
	  }else{
				$gonggao[0]['news_title']='新闻公告';
				$gonggao[0]['news_id']='0';
	    }
	 return $gonggao;  
	}

	/**
	* getShopShow 获取首页买家秀数据
	* @return [type] [description]
	*/
	public function getShopShow()
	{
	//买家秀 
	$mapmjx=array();
	$mapmjx['news_type']=2;
	$mapmjx['news_unitcode']=$this->qy_unitcode;
	$datamjx=M('Jfmonews')->where($mapmjx)->field('news_id,news_title,news_content,news_pic,news_addtime,news_type')->order('news_addtime DESC')->limit(2)->select();
	if ($datamjx)
	{
	  $index=0;
	  foreach ($datamjx as $k => $v) {
	    $datamjx[$k]['news_index']=$index;
	    $index++;
	    // if(is_not_null($v['news_pic']) && file_exists(IMGPRODUCTPATH.$v['news_pic'])){
	    if(is_not_null($v['news_pic'])){
	      $datamjx[$k]['news_pic_str']=$this->ImagePath.$v['news_pic'];
	    }else{
	      $datamjx[$k]['news_pic_str']='';
	    }
	  }
	}
	return $datamjx;
	}

	/**
	* base_info_get 获取公告基本信息
	* @param btype 1、公司简介2、公司政策
	*/
	public function base_info_get()
	{
	isset($this->params["btype"]) ? $btype = $this->params["btype"] : $btype =''; //代表查询的初始条件
	$Jfmobasic=M('Jfmobasic');
	$map=array();
	$map['bas_unitcode']=$this->qy_unitcode;
	$result =$Jfmobasic->where($map)->find();
	if ($result)
	{
	  switch ($btype) {
	    case 1:
	      return $result['bas_profile'];
	    break;
	    case 2:
	      return $result['bas_ppzc'];
	    break;
	    default:
	      return '数据有待于更新...';
	      break;
	  }

	}else
	{
	  $this->err_get(4);
	}
	}


	/**
	* news_list_get 获取新闻信息列表
	*@param ntype 0、公告1、企业动态2、买家秀4、素材圈5、招商政策6、培训机构7、商家活动
	*/
	public function news_list_get()
	{
		isset($this->params["ntype"]) ? $ntype = $this->params["ntype"] : $ntype =0;
		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
		isset($this->params["pagecount"]) ? $pagecount = $this->params["pagecount"] : $pagecount =1;

		// 查询状态为1的用户数据 并且每页显示10条数据 总记录数为1000
		$pageinit=[
		  'type'     => 'bootstrap',
		  'page' =>$pagenum,
		  // 'list_rows' =>$pagecount,
		];
		$Jfmonews=M('Jfmonews');
		$map=array();
		$map['news_unitcode']=$this->qy_unitcode;
		$map['news_type']=$ntype;
		// $list =$Jfmonews->where($map)->paginate($pagecount,true,$pageinit)->each(function($item, $key){
		//   // if(is_not_null($item['news_pic']) && file_exists(IMGPRODUCTPATH.$item['news_pic'])){
		//   if(is_not_null($item['news_pic'])){
		//     $item['news_pic_str']=$this->ImagePath.$item['news_pic'];
		//   }else{
		//     $item['news_pic_str']='';
		//   }
		//   // $item['news_addtime_str']=date('Y-m-d H:i:s',$item['news_addtime']);
		//   $item['news_addtime_str']=date('Y-m-d',$item['news_addtime']);
		//   return $item;
		// });
		$list =$Jfmonews->where($map)->page($pagenum,$pagecount)->select();
		if (is_not_null($list))
		{
			foreach ($list as $k=>$v) {
			  if($v['news_pic']!=''){
			     $list[$k]['news_pic_str']=IMGPATH.$v['news_pic'];
			  }else{
			     $list[$k]['news_pic_str']='';
			  }
			  $list[$k]['news_addtime_str']=date('Y-m-d',$v['news_addtime']);
			}
		}else
		{
			$list=array();
		}
		$has_more=false;
		$nextls =$Jfmonews->where($map)->page($pagenum+1,$pagecount)->select();
		if (is_not_null($nextls))
		{
			$has_more=true;
		}
		$data=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
		return $data;
	}

	/**
	* news_detail_get 获取新闻信息详情
	*@param newid 
	*/
	public function news_detail_get()
	{
	isset($this->params["newid"]) ? $newid = $this->params["newid"] : $newid ='';
	if (is_not_null($newid))
	{
	  $Jfmonews=M('Jfmonews');
	  $map=array();
	  $map['news_unitcode']=$this->qy_unitcode;
	  $map['news_id']=$newid;
	  $list =$Jfmonews->where($map)->find();
	  return $list;
	}else
	{
	  $this->err_get(4);
	}
	}

	/**
    * 上传图片
    * @param $code
    * @return bool
  	*/
	  public function uploadimg()
	  {
	  	 $headerArr=$this->request['header'];
	  	 if (!isset($headerArr['token'])){
            if(isset($headerArr['unit_token'])){
               $ttamp= $headerArr['ttamp'];
               $randomchar= $headerArr['randomchar'];
               $unit_uuid= $headerArr['unit_uuid'];
               $unit_uuid_str=$this->aes->decrypt($unit_uuid);
               $qy_unit_uuid=mb_substr($unit_uuid_str,mb_strlen($this->qy_appname),mb_strlen($unit_uuid_str)-mb_strlen($this->qy_appname),'utf-8');
               if ($qy_unit_uuid!=$this->qy_unitcode)
               	$this->err_get(3); 
               $unit_token= $headerArr['unit_token'];
               // var_dump(phpinfo());
               // exit;
               $unit_token_cache=S($this->qy_appname.$qy_unit_uuid);
               if ($unit_token_cache)
               {
                   $qy_unit_token=MD5($ttamp.$randomchar.$unit_token_cache);
                   if($unit_token!=$qy_unit_token)
                     $this->err_get(3);
               }else
               {
                    $Qyinfo=M('Qyinfo');
                    $map['qy_code']=$this->qy_unitcode;
                    $data=$Qyinfo->where($map)->field('qy_fwkey')->find();
                    if($data){
                        if (isset($data['qy_fwkey']))
                        {
                            $unit_ssid=strtoupper($this->aes->encrypt($this->qy_appname.$this->qy_unitcode));
                            $unit_Token=strtoupper($this->aes->encrypt($data['qy_fwkey']));
                            S($this->qy_appname.$this->qy_unitcode,$unit_Token,72000);
                        }
                        else
                             $this->err_get(4);
                    }else
                    {
                        $this->err_get(3);
                    }
               }
            }else
            {
                $this->err_get(3);
            }
        }

	  	if (is_not_null($_FILES))
	  	{
	  		$this->upload_files($_FILES,IMGTEMP);
	  	}else
	  	{
	  		$this->err_get('请选择上传图片');
	  	}
	  }

	public function _empty()
	{
	  header('HTTP/1.0 404 Not Found');
	  echo'error:404';
	  exit;
	}
	
	
}