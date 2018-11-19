<?php
namespace Mp\Controller;
use Think\Controller;
//统计图示
class EchartsController extends CommController {
   //子用户列表 用于APP出货扫描 或 管理
    public function index(){
    $this->check_qypurview('100001',1);
	// $map['su_unitcode']=session('unitcode');
	// $map['su_belong']=0;
	// $map['su_user'name'']=array('neq','');
	// $Qysubuser = M('Qysubuser');
	// $list = $Qysubuser->where($map)->order('su_id DESC')->select();
	// $this->assign('qysubuserlist', $list);

	$this->assign('qyuser', session('qyuser'));
    $this->assign('curr', 'echarts');
    $this->display('index');
    }
    public function fullscreen()
    {
    	 $this->check_qypurview('100001',1);
    	 $this->assign('qyuser',session('qyuser'));
    	 $this->assign('curr', 'echarts');
    	 $this->display('fullscreen');
    }


    public function echarts_data_get()
    {
    	$this->check_qypurview('100001',1);
    	$qyuser=trim(I('param.qyuser',''));
    	$data['admin_deal']['data']=$this->admin_deal_get();
    	$data['admin_sales']['data']=[];
    	$data['agent_achievement']['data']=[];
    	$data['agent_distribute']['data']=$this->agent_distribute_get();
    	$data['agent_join_trend']['data']=$this->agent_join_trend_get();
    	$data['agent_stock_trend']['data']=[];
    	$data['info']['data']=$this->baseinfo_get();
    	$data['orders_area_distribute']=$this->order_area_top_get();
    	$data['performance_top_five']['data']=[];
    	$data['purchase_team_number']['data']=$this->agent_team_top5_get();
    	$data['real_time_orders']['data']=[];
    	$data['real_time_orders_transport']['data']=$this->map_series_get();
    	$ret=array('status' =>1,'data' =>$data);
    	echo json_encode($ret);
		exit;
    }

    public function admin_deal_get(){
    	$dealData=array();
    	$dealData['today']=16838.00;
    	$dealData['total']=518668.00;
    	$dealData['yesterday']=8680.00;
    	return $dealData;
    }

    public function order_area_top_get(){
    	$orderTopData=array();
    	$orderTopObject['name']='top1 广东省/1000单';
    	$orderTopObject['value']=50;
    	array_push($orderTopData,$orderTopObject);
    	$orderTopObject2['name']='top2 湖北省/500单';
    	$orderTopObject2['value']=25;
    	array_push($orderTopData,$orderTopObject2);
    	$orderTopObject3['name']='top3 江苏省/200单';
    	$orderTopObject3['value']=10;
    	array_push($orderTopData,$orderTopObject3);
    	$orderTopObject4['name']='top4 湖南省/200单';
    	$orderTopObject4['value']=10;
    	array_push($orderTopData,$orderTopObject4);
    	$orderTopObject5['name']='top3 广西省/100单';
    	$orderTopObject5['value']=5;
    	array_push($orderTopData,$orderTopObject5);
    	return $orderTopData;
    }

    public function baseinfo_get(){
    	$infoData=(Object)array();
    	$infoData->logo="http://".$_SERVER['HTTP_HOST'].WWW_WEBROOT.'public/mp/img/logo_icon.png';
    	$infoData->title='康利微商2.0大屏作战系统';
    	return $infoData;
    }

    public function agent_distribute_get()
    {
    	$agentDistributeData=array();
    	$agentOjbect['name']='联合创始人';
    	$agentOjbect['value']=100;
    	array_push($agentDistributeData,$agentOjbect);

    	$agentOjbect1['name']='合伙人';
    	$agentOjbect1['value']=200;
    	array_push($agentDistributeData,$agentOjbect1);

    	$agentOjbect2['name']='总代';
    	$agentOjbect2['value']=300;
    	array_push($agentDistributeData,$agentOjbect2);

    	$agentOjbect3['name']='一级代理';
    	$agentOjbect3['value']=500;
    	array_push($agentDistributeData,$agentOjbect3);

    	$agentOjbect4['name']='二级代理';
    	$agentOjbect4['value']=800;
    	array_push($agentDistributeData,$agentOjbect4);

    	return $agentDistributeData;
    }
 	public function agent_team_top5_get(){
 		$agentTeamTop5Data=array();
 		$agentTeamTop5Ojbect['name']='团队';
    	$agentTeamTop5Ojbect['value']=1000;
    	array_push($agentTeamTop5Data,$agentTeamTop5Ojbect);

    	$agentTeamTop5Ojbect1['name']='李生团队';
    	$agentTeamTop5Ojbect1['value']=500;
    	array_push($agentTeamTop5Data,$agentTeamTop5Ojbect1);

    	$agentTeamTop5Ojbect2['name']='陈生团队';
    	$agentTeamTop5Ojbect2['value']=300;
    	array_push($agentTeamTop5Data,$agentTeamTop5Ojbect2);

   		$agentTeamTop5Ojbect3['name']='黄生团队';
    	$agentTeamTop5Ojbect3['value']=200;
    	array_push($agentTeamTop5Data,$agentTeamTop5Ojbect3);
    	return $agentTeamTop5Data;
	}

	public function agent_join_trend_get(){
		$agentJoinTrendData=array();
		$agentJoinTrendObject['name']='2018-03-01';
		$agentJoinTrendObject['value']=200;
		array_push($agentJoinTrendData,$agentJoinTrendObject);
		return $agentJoinTrendData;
	}

    public function map_series_get()
    {
    	$mapSeries=array();
    	$admin=array();
    	$admin['address']='广州';
    	$admin['lng']='113.23';
    	$admin['lat']='23.16';
    	$mapSeries['admin']=$admin;
    	// var $GZData = [[{'name':'广州'},{'name':'福州','value':95}],
					//     [{'name':'广州'},{'name':'太原','value':90}],
					//     [{'name':'广州'},{'name':'长春','value':80}],
					//     [{'name':'广州'},{'name':'重庆','value':70}],
					//     [{'name':'广州'},{'name':'西安','value':60}],
					//     [{'name':'广州'},{'name':'成都','value':50}],
					//     [{'name':'广州'},{'name':'常州','value':40}],
					//     [{'name':'广州'},{'name':'北京','value':30}],
					//     [{'name':'广州'},{'name':'北海','value':20}],
					//     [{'name':'广州'},{'name':'海口','value':10}]];
		$lineSeries=array();
		$lineObject['fromName']='广州';
		$lineObject['toName']='北京';
		$lineObject['coords']=[[113.23,23.16],[116.46,39.92]];
		array_push($lineSeries,$lineObject);

		$lineObject2['fromName']='广州';
		$lineObject2['toName']='武汉';
		$lineObject2['coords']=[[113.23,23.16],[114.31,30.52]];
		array_push($lineSeries,$lineObject2);

		$lineObject3['fromName']='广州';
		$lineObject3['toName']='上海';
		$lineObject3['coords']=[[113.23,23.16],[121.48,31.22]];
		array_push($lineSeries,$lineObject3);

    	$mapSeries['transport']=$lineSeries;

		$pointSeries=array();
		$pointObject['name']='北京';
		$pointObject['value']=[116.46,39.92,20];
		array_push($pointSeries,$pointObject);
		$pointObject2['name']='武汉';
		$pointObject2['value']=[114.31,30.52,20];
		array_push($pointSeries,$pointObject2);
		$pointObject3['name']='上海';
		$pointObject3['value']=[121.48,31.22,20];
		array_push($pointSeries,$pointObject3);
		// var_dump($lineSeries);
		// exit;		   
    	$mapSeries['orders']=$pointSeries;
    	//读取本地js
    	// $json_string =file_get_contents(BASE_PATH.'/public/mp/js/mapseries.json');   
    	// 用参数true把JSON字符串强制转成PHP数组    
   		// $series_data =json_decode($json_string,true);
   		//或调用系统load_config函数读取json格式文件
   		$series_data =load_config(WWW_WEBROOT.'/public/mp/js/mapseries.json');
    	// var_dump($series_data);
    	// exit;
    	return $mapSeries;
    }
}