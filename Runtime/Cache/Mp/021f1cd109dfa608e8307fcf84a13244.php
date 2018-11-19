<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大数据统计</title>
<link rel="stylesheet" type="text/css" href="/Kangli/Public/mp/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Kangli/Public/mp/css/jquery-confirm.min.css"/>
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery.min.js"></script>
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery-confirm.min.js"></script>
  <script src="/Kangli/Public/mp/js/echarts/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="/Kangli/Public/mp/js/echarts/layer.js"></script>
  <script src="/Kangli/Public/mp/js/echarts/echarts.min.js"></script>
  <script src="/Kangli/Public/mp/js/echarts/china.js"></script>
<!--   <link rel="stylesheet" href="/Kangli/Public/mp/css/layer.css" id="layuicss-layer"> -->
<style type="text/css">
  *{margin:0;padding:0;}
    img[src=""] {
      opacity: 0;
    }
    html {
        /*background-color:#013b79;*/
        overflow: hidden;
        /*background: url('./images/bg-title.png') top center no-repeat; 
        background-size:cover;*/
    }
    body{
        overflow: hidden;
        font-family:"微软雅黑";
    }
  #join {
    height: 270px;
    width: 410px;
    float: left;
    margin-top: 25px
  }
  #take, #sales-trend {
    height: 270px;
    width: 430px;
    float: left;
    margin-top: 25px
  }
  .timelyContent {
    position: absolute;
    bottom: 280px;
    margin-left: 45px;
    overflow: hidden
  }
  .timelyContent li {
    width: 100%;
    height: 35px;
    line-height: 35px;
    list-style: none;
    font-size: 13px;
  }
  .today {
    color: #76ddea;
  }
  .time {
    position: absolute;
    color: #76ddea;
    right: 0;
  }
  .number {
    margin-top: 10px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
  }
  .number div {
    width: 60px;
    height: 80px;
    line-height: 80px;
    border: 2px #00aae8 solid;
    border-radius: 5px;
    text-align: center;
    color: #fff;
    font-size: 50px;
    font-weight: 300;
  } 
  .total {
    position: absolute;
    color: #76ddea;
  }
  .yestoday {
    position: absolute;
    color: #76ddea;
    right: 0;
  }
  #order-top {
    position: absolute;
    top: 114px;
    right: 315px;
    width: 272px;
    height: 320px;
    background: url('/Kangli/Public/mp/img/bg-tr.png') center center / auto 100%  no-repeat;

  }
  #order-top p, #totalAmount > p, #agent-team >p {
        color:#00fff7;
    position: absolute;
        line-height: 45px;
    top: -20px;
        left: 50%;
        transform: translateX(-50%);
        background:url('/Kangli/Public/mp/img/title-bg.png') no-repeat;
        background-size:  100% 100%;
    text-align: center;
    font-size: 20px;
  }
   #order-top div,#agent-spread div, #agent-team div {
    width: 100%;
    height: 100%
  }
  #map {
    position:absolute;
    top:0px;
    left:0px
  }
  #agent-spread {
    position: absolute;
    top:118px;
    left: 15px;
    width: 558px;
    height: 339px;
    background: url('/Kangli/Public/mp/img/bg-tl.png') center center / auto 100%  no-repeat;
  }

  #agent-spread p {
    width: 170px;
        color:#00fff7;
        line-height: 45px;
        transform: translateX(-50%);
        background:url('/Kangli/Public/mp/img/title-bg.png') no-repeat 100% 100%;
        background-size: cover;
        text-align: center;
        font-size: 20px;
        position: absolute;
        top: 5px;
        left: 150px;
        font-size: 20px;
  }
  #agent-team {
    position: absolute;
    top:490px;
    left: 15px;
    width: 558px;
    height: 300px;
  }
  #title {
    width: 100%;
    height: 80px;
    position: absolute;
    top: 0;
    background: url('/Kangli/Public/mp/img/bg-title.png') no-repeat;
    text-align: center;
    line-height: 80px;
  }
  #title img {
    width: 60px;
    height: 60px;
    margin: 10px 0;
    /*border-radius: 50%;*/
    }
  #title span {
    display: inline-block;
    vertical-align: top;
    color: white;
    font-size: 36px;
    margin-left: 60px;
  }
  #timely {
    width: 466px;
    height: 305px;
    position: absolute;
    right: 295px;
    top: 440px;
    background: url(/Kangli/Public/mp/img/timely-content.png) no-repeat;
        background-size: 100% 100%; 
  }
  #timely > p, #monthTop5 > p {
        width: 170px;
        color:#00fff7;
        line-height: 45px;
        background:url('/Kangli/Public/mp/img/title-bg.png') no-repeat 100% 100%;
        background-size: cover;
        text-align: center;
        font-size: 20px;
    position: absolute;
    left: 50px;
    font-size: 20px;

  }
  #statistics {
    width: 703px;
    height: 190px;
    position: absolute;
    margin: 20px auto;
    left: -64px;
    right: 0;
    top: 124px;
  }
  #totalAmount {
    width: 15%;
    height: 68%;
    position: absolute;
    right: 10px;
    top: 113px;
    background: url(/Kangli/Public/mp/img/bg-totalamount.png) no-repeat;
  }
  .amountContent {
    margin-top: 36px;
        overflow: hidden;
        height: 580px;
  }
  #monthTop5 {
    width: 30%;
    height: 30%;
    position: absolute;
    bottom: -25px;
    left: 5px;
    background: url(/Kangli/Public/mp/img/bg-monthtop5.png) no-repeat;
  }
  .top5Content {
    margin-top: 70px;
  }
    #bottom-modal p{
        position: absolute;
        color:#00fff7;
        z-index: 10000;
        line-height: 45px;
        background:url('/Kangli/Public/mp/img/title-bg.png') no-repeat 100% 100%;
        background-size: cover;
        text-align: center;
        font-size: 20px;
        top:8px;
        width: 170px;
        left: 50%;
        transform: translateX(-50%);
    }
    #bottom-modal div{
        overflow: hidden;
        display: inline-block;
    }
</style>
</head>
<body style="width: 1920px; height: 1080px; position: absolute; top: 0px; left: 0px; transform-origin: left top 0px; background: url(/Kangli/Public/mp/img/big-bg.jpg) no-repeat; transform:scale(1);">
  <div id="title">
    <img src="/Kangli/Public/mp/img/logo_icon.png">
    <span>康利微商2.0大屏作战系统</span>
  </div>
  <div id="map" _echarts_instance_="ec_1522407376589" style="-webkit-tap-highlight-color: transparent; user-select: none; min-height: 1080px; min-width: 1920px; background: transparent;"><div style="position: relative; overflow: hidden; width: 1920px; height: 1080px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas width="1920" height="1080" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 1920px; height: 1080px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas><canvas width="1920" height="1080" data-zr-dom-id="zr_2" style="position: absolute; left: 0px; top: 0px; width: 1920px; height: 1080px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
  <div id="order-top">
    <div id="order-top-main" _echarts_instance_="ec_1522407376590" style="-webkit-tap-highlight-color: transparent; user-select: none; background: transparent;"><div style="position: relative; overflow: hidden; width: 272px; height: 320px; padding: 0px; margin: 0px; border-width: 0px; cursor: pointer;"><canvas width="272" height="320" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 272px; height: 320px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div></div>
    <p class="title" style="width: 210px;line-height: 45px;">订单区域分布TOP5</p>
  </div>
  <div id="agent-spread">
    <div id="agent-spread-main" _echarts_instance_="ec_1522407376591" style="-webkit-tap-highlight-color: transparent; user-select: none; background: transparent;"><div style="position: relative; overflow: hidden; width: 558px; height: 339px; padding: 0px; margin: 0px; border-width: 0px;"><canvas width="558" height="339" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 558px; height: 339px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div></div>
    <p class="title">代理分布</p>
  </div>
  <div id="agent-team">
    <div id="agent-team-main" _echarts_instance_="ec_1522407376592" style="-webkit-tap-highlight-color: transparent; user-select: none; background: transparent;"><div style="position: relative; overflow: hidden; width: 558px; height: 300px; padding: 0px; margin: 0px; border-width: 0px;"><canvas width="558" height="300" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 558px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div></div>
        <p style="width: 208px"> 代理进货人数TOP5</p>
  </div>
  <div id="statistics">
    <span class="today">今日支付金额：0.00</span>
    <span class="time"></span>
    <div class="number" style="width: 100%">
      <div>0</div>
      <div>0</div>
      <div>0</div>
      <div>0</div>
      <div>0</div>
      <div>0</div>
      <div>0</div>
      <div>0</div>
      <div>0</div>
      <div>0</div>
    </div>
    <span class="total">累计支付金额：0.00</span>
    <span class="yestoday">昨日支付金额：0.00</span>
  </div>
  <div style="" id="timely">
    <p>实时订单信息</p>
    <div style="overflow: hidden;height: 210px;margin-top: 60px;position: relative;">
      <div class="timelyContent" style="bottom: 0px;">
        <ul><li style="height: 36px; margin: 0;"><p style="color: white;">19:24:26  "三级" 陈(130****6689)下单，金额3327.00元</p></li><li style="height: 36px; margin: 0;"><p style="color: white;">19:24:26  "省代" 陈彬(150****3876)下单，金额15916.00元</p></li><li style="height: 36px; margin: 0;"><p style="color: white;">19:24:26  "省代" 杨会琴(158****3973)下单，金额1230.00元</p></li><li style="height: 36px; margin: 0;"><p style="color: white;">19:24:26  "vip" 杨小娟(131****5913)下单，金额5321.00元</p></li><li style="height: 36px; margin: 0;"><p style="color: white;">19:24:26  "联合创始人" wch(183****3939)下单，金额11913.00元</p></li><li style="height: 36px; margin: 0;"><p style="color: white;">19:21:54  "省代" 郑君(132****9320)下单，金额5723.00元</p></li>
        </ul>
      </div>
    </div>


  </div>
  <div id="totalAmount">
    <div class="amountContent">
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO1</span>&nbsp;&nbsp;679612元<span style="float: right; margin-right: 35px">徐宇(183****4797)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO2</span>&nbsp;&nbsp;278634元<span style="float: right; margin-right: 35px">陈晨(158****2698)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO3</span>&nbsp;&nbsp;275541元<span style="float: right; margin-right: 35px">段梦琪(155****0784)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO4</span>&nbsp;&nbsp;263102元<span style="float: right; margin-right: 35px">范思欣(151****9980)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO5</span>&nbsp;&nbsp;263000元<span style="float: right; margin-right: 35px">庄素云(130****5571)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO6</span>&nbsp;&nbsp;259741元<span style="float: right; margin-right: 35px">沈丽娇(139****7400)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO7</span>&nbsp;&nbsp;251203元<span style="float: right; margin-right: 35px">汪贺(189****3009)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO8</span>&nbsp;&nbsp;247156元<span style="float: right; margin-right: 35px">孟志远(132****7711)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO9</span>&nbsp;&nbsp;244410元<span style="float: right; margin-right: 35px">翁春(133****9505)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO10</span>&nbsp;&nbsp;238877元<span style="float: right; margin-right: 35px">高彦金(187****4469)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO11</span>&nbsp;&nbsp;233001元<span style="float: right; margin-right: 35px">魏健(153****3360)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO12</span>&nbsp;&nbsp;230018元<span style="float: right; margin-right: 35px">丁怡悦(139****0012)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO13</span>&nbsp;&nbsp;224787元<span style="float: right; margin-right: 35px">熊泓萱(138****4451)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO14</span>&nbsp;&nbsp;223099元<span style="float: right; margin-right: 35px">高琳(188****9665)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO15</span>&nbsp;&nbsp;217733元<span style="float: right; margin-right: 35px">梁艾彬(189****0048)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO16</span>&nbsp;&nbsp;210369元<span style="float: right; margin-right: 35px">叶湘润(136****2021)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO17</span>&nbsp;&nbsp;209987元<span style="float: right; margin-right: 35px">毛涵宇(137****9779)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO18</span>&nbsp;&nbsp;208634元<span style="float: right; margin-right: 35px">段永杰(186****3302)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO19</span>&nbsp;&nbsp;201233元<span style="float: right; margin-right: 35px">王琳艳(158****0051)<span></span></span></p>
    <p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"><span style="color:#ffce37">NO20</span>&nbsp;&nbsp;199781元<span style="float: right; margin-right: 35px">丁广义(155****0639)<span></span></span></p></div>
    <p style="width: 210px">代理累计业绩排行榜</p>
  </div>
  <div id="monthTop5">
    <p>本月业绩TOP5</p>
    <div class="top5Content"><p style="color: white; margin-left: 60px; font-size: 14px; font-weight: lighter; margin-top: 15px">TOP1&nbsp;&nbsp;邓欢欢(136****1587)本月业绩77864.15</p><p style="color: white; margin-left: 60px; font-size: 14px; font-weight: lighter; margin-top: 15px">TOP2&nbsp;&nbsp;陆渝飞(185****9971)本月业绩71663.07</p><p style="color: white; margin-left: 60px; font-size: 14px; font-weight: lighter; margin-top: 15px">TOP3&nbsp;&nbsp;赵琳(139****1483)本月业绩70006.98</p><p style="color: white; margin-left: 60px; font-size: 14px; font-weight: lighter; margin-top: 15px">TOP4&nbsp;&nbsp;曾幸薇(138****7487)本月业绩65700.09</p><p style="color: white; margin-left: 60px; font-size: 14px; font-weight: lighter; margin-top: 15px">TOP5&nbsp;&nbsp;马莉莉(151****3699)本月业绩54750.08</p></div>
  </div>
  <div style="width: 70%; height: 30%; position: absolute;top: 765px; left: 30%; background: url(/Kangli/Public/mp/img/bg-bottom.png) no-repeat;" id="bottom-modal">
        <div style="margin-left: 40px;position: relative;overflow: hidden;">
            <div id="join" _echarts_instance_="ec_1522407376594" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;"><div style="position: relative; overflow: hidden; width: 410px; height: 270px; padding: 0px; margin: 0px; border-width: 0px;"><canvas width="410" height="270" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 410px; height: 270px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
            <p>代理加入趋势</p>
        </div>
    <div style="left: -20px;position: relative;overflow: hidden;">
            <div id="take" _echarts_instance_="ec_1522407376595" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;"><div style="position: relative; overflow: hidden; width: 430px; height: 270px; padding: 0px; margin: 0px; border-width: 0px;"><canvas width="430" height="270" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 430px; height: 270px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
            
        </div>
    <div style="position:relative;overflow: hidden;">
            <div id="sales-trend" _echarts_instance_="ec_1522407376593" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;"><div style="position: relative; overflow: hidden; width: 430px; height: 270px; padding: 0px; margin: 0px; border-width: 0px;"><canvas width="430" height="270" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 430px; height: 270px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
            <p>总部销量趋势</p>
        </div>
        <p style="top: -16px;left: 635px">代理进货趋势</p>
  </div>

<script>
  var count = 0;
  var myChart = echarts.init(document.getElementById('map')),
      orderTopChart = echarts.init(document.getElementById('order-top-main')),
      agentSpreadChart = echarts.init(document.getElementById('agent-spread-main')),
      agentTeamChart = echarts.init(document.getElementById('agent-team-main')),
      salesTrendChart = echarts.init(document.getElementById('sales-trend')),
      joinChart = echarts.init(document.getElementById('join')),
      takeChart = echarts.init(document.getElementById('take'));
  function getSeries(datas){
    var series = [];
    series.push({
      name: '线',
      type: 'lines',
      zlevel: 2,
      effect: {
        show: true,
        period: 2,
        trailLength: 0.05,
        color: 'rgba(177,253,253,.8)',
        symbol:'rect',
        symbolSize: [2, 50]
      },
      lineStyle: {
        normal: {
          color: '#a6c84c',
          width: 0,
          type:'solid',
          curveness: 0
        }
      },
      data: datas.transport
    },
    {
      name:'闪点',
      type: 'effectScatter',
      coordinateSystem: 'geo',
      zlevel: 2,
      data:datas.orders,
      rippleEffect: {
        period:2,
        brushType: 'stroke'
      },
      label: {
        normal: {
          show: false,
          position: 'right',
          formatter: '{b}'
        },
        emphasis:{
          show:false
        }
      },
      symbolSize: function (val) {
        console.log(val);
        // return Math.floor(val[2]/10)+8;
        return Math.floor(val[2]/10);
      },
      itemStyle: {
        normal: {
          color: 'rgba(255, 255, 255, 0.7)'
        }
      },
      tooltip:{
        show:false
      }
    },
    {
      name:'总部',
      type: 'effectScatter',
      coordinateSystem: 'geo',
      zlevel: 2,
      data: [{name:datas.admin.address,value:[datas.admin.lng, datas.admin.lat]}],
      rippleEffect: {
        period:2,
        brushType: 'stroke'
      },
      label: {
        normal: {
          show: false,
          position: 'right',
          formatter: '{b}'
        },
        emphasis:{
          formatter: function(val){
            return val;
          }
        }

      },
      symbolSize: function () {
        return 20;
      },
      itemStyle: {
        normal: {
          color: 'red'
        }
      },
      tooltip:{
        formatter:function(val){
          return val.data.name
        }
      }

    }
    );
    return series;
  }
  //地图
  function mapOption(data){
    var option = {
      tooltip : {
        trigger: 'item'
      },
      geo: {
        map: 'china',
        zoom:0.6,
        // roam:true,
        center:[110,36],
        label: {
          normal: {
            show: false,
            textStyle: {
              color: '#67c0e7'
            }
          },
          emphasis:{
            show: true,
            textStyle: {
              color: '#67c0e7'
            }
          }
        },
        itemStyle: {
          normal:{
            borderColor: '#67c0e7',
            areaColor:'rgba(0,0,0,0)'
          },
          emphasis:{
            borderColor: '#67c0e7',
            areaColor:'rgba(0,0,0,0)',
            shadowOffsetX: 0,
            shadowOffsetY: 0,
            shadowBlur: 0,
            borderWidth: 1,
            shadowColor: 'rgba(0, 0, 0 ,1)'
          }
        }
      },
      series:getSeries(data)
    };
    return option;
  }
  //订单top5
  function orderTopOption(data){
      var color=['#ff8937','#52bdcf','#f68e85','#b1d9fd','#f4bad3'];
      var seriesLabel = {
          normal: {
              show: true,
              color: 'white',
              position:[10,-20],
              formatter:'{a}'
          }
      };
      var datas = data.map(function(value, i){
          var info = {
              name: value.name,
              type: 'bar',
              barGap:'175%',
              data: [value.value],
              barWidth:20,
              label: seriesLabel,
              labelLine:{
                  normal:{
                      itemStyle:{
                          width:1
                      },
                      length:0,
                      length2:10
                  }
              },
              itemStyle:{
                  normal:{
                      color:color[i]
                  }
              },
              markPoint: {
                  symbolSize: 1,
                  label: {
                      normal: {
                          formatter: '{c}%',
                          position: 'right',
                      }
                  },
                  itemStyle:{
                      normal:{
                          color:'white'
                      }
                  },
                  data: [
                  {type: 'max', name: 'max days: '},
                  {type: 'min', name: 'min days: '}
                  ]
              }
          };
          return info;
      });
    

    var option = {
      grid: {
        top: 100
      },
      xAxis: {
        type: 'value',
        name: 'Days',
        show:false,
              boundaryGap:[0, '20%'],
        axisLabel: {
          formatter: '{value}'
        }
      },
      yAxis: {
        type: 'category',
        show:false,
      },
      series: datas
    };
    return option;
  }
  //代理分布
  function agentSpreadOption(data){
      var color = ['#ff6801', '#12d540', '#00d5eb', '#0558b5', '#f1b14a', '#4024ff', '#9d5aab', '#ff4e4e', '#2cc383', '#2cc383'];
      var datas= data.map(function(val, i){
          return {
              name:val.name,
              value:val.value,
              itemStyle:{
                  normal:{
                      color:color[i]
                  }
              }
          };
      })
    option = {
      series : [
      {
        name:'访问来源',
        type:'pie',
              minAngle:30,
        radius :  ['10%','55%'],
        center: ['50%', '50%'],
        data:datas,
        roseType: 'redius',
        label:{
          normal: {
            textStyle: {
              color: 'rgba(255, 255, 255, 1)'
            },
            formatter: [
                      '{name|{c}({d}%)}',
            '{hr|}',
            '{title|{b}}',
            ].join('\n'),
            rich: {
              title:{
                align:'center',
                height:20,
                color:'white'
              },
              hr:{
                borderColor: 'white',
                width: '100%',
                borderWidth: 1,
                height: 0
              },
              name:{
                color:'white',
                align:'center',
                height:20
              }
            }
          }
        },
        labelLine: {
          normal: {
            lineStyle: {
              color: 'rgba(255, 255, 255, 1)',
              width:1
            },
            length:0,
            length2:30
          }
        },
        itemStyle: {
          normal: {
            shadowBlur: 200,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        },
        animationType: 'scale',
        animationEasing: 'elasticOut',
        animationDelay: function (idx) {
          return Math.random() * 200;
        }
      }
      ]
    };
    return option;
  }

  //代理团队人数TOP5
  function agentTeamOption(data){
      var datas = data.map(function(val, i){
          var opacity= 1-i*0.1;
          return  {   
                  value:val.value, 
                  name: val.name,
                  itemStyle:{
                      normal:{
                          color:'rgba(255, 105, 1, '+opacity+')'
                      }
                  }
              }
      })
    option = {
      series : [
      {
        type: 'pie',
              minAngle:15,
        radius : '50%',
        clockwise:false,
        center: ['50%', '60%'],
        selectedMode: 'single',
              markPoint: {
                  symbolSize: 1,
                  label: {
                      normal: {
                          formatter: '{c}%',
                          position: 'right',
                      }
                  },
                  itemStyle:{
                      normal:{
                          color:'white'
                      }
                  },
                  data: [
                  {type: 'max', name: 'max days: '},
                  {type: 'min', name: 'min days: '}
                  ]
              },
              labelLine: {
                  normal: {
                      lineStyle: {
                          color: 'rgba(255, 255, 255, 1)',
                          width:1
                      },
                      length:10,
                      length2:30
                  }
              },
        label: {
          normal: {
            itemStyle:{
              color:'white'
            },
            formatter: [ 
                      '{number|占代理总人数{c}%}',
            '{hr|}',
                      '{percent|{b}}{abg|}',
            ].join('\n'),
            rich: {
              hr:{
                borderColor: 'white',
                              position:'relative',
                              left:100,
                width: '100%',
                borderWidth: 1,
                height: 0

              },
              percent:{
                height:20,
                align:'center',
                color:'white'
              },
              number:{
                height:20,
                align:'center',
                color:'white'
              }
            }
          }
        },
        data:datas,
        itemStyle: {
          emphasis: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        }
      }
      ]
    };
    return option;
  }
  //总部销量趋势
  function salesTrendOption(data){
      var quantityName = "数量"
      if (Math.max.apply(null, data.value) > 10000) {
          quantityName = "数量（万）";
          for (var i = 0; i < data.value.length; i++) {
              data.value[i] = (Number(data.value[i]) / 10000).toFixed(6);
          }
      }
    option = {
      
      tooltip: {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
          type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
      },
      grid: {
        show: true,
        backgroundColor: 'rgba(3, 52, 94, 0.88)',
        borderColor: '#2684b1',
        borderWidth: 2,
              left:'15%'
      },
      xAxis: {
        axisLine: {
          show: false
        },
        axisTick: {
          length: 0
        },
        axisLabel: {
          interval: 0, 
          textStyle: {
            color: '#2dd8d3',
            fontSize: 12
          }
        },
        splitLine: {
          show: true,
          interval: 0, 
          lineStyle: {
            color: 'rgba(38, 133, 180, 0.3)'
          }
        },
        data: data.name,
      },
      yAxis: {
              name:quantityName,
              nameTextStyle: {
                  color: '#2dd8d3',
              },
        type: 'value',
        // interval: 5,
        axisLine: {
          show: false
        },
        axisTick: {
          length: 0
        },
        axisLabel: {
          interval: 2,
          textStyle: {
            color: '#2dd8d3',
            fontSize: 12
          }
        },
        splitLine: {
          show: true,
          interval: 0,
          lineStyle: {
            color: 'rgba(38, 133, 180, 0.3)'
          }
        }
      },
      series: [{
        name: '销量',
        type: 'bar',
        barWidth:'50%',
        itemStyle: {
          normal: {
            color: '#2dd8d3',
            lineStyle: {
              color: '#2dd8d3',
            },
            areaStyle: {
              color: 'rgba(3, 52, 94, 0.88)'
            }
          }
        },
        areaStyle: {
          normal: {
            color: '#fff',
            opacity: 0
          }
        },
        data: data.value
      }]
    };
    return option;
  }
  // 统计数据
  function statistics(data) {
    var str = String(data.today);
    var count = str.length;
    for (var i = 0; i < 10 - count; i++) {
      $($('.number div')[i]).text("0");
    }
    for (var j = 10-count; j < 10; j++) {
      $($('.number div')[j]).text(str[j-10+count]);
    }
    $('.today').text("今日支付金额：" + (data.today));
    $('.total').text("累计支付金额：" + (data.total));
    $('.yestoday').text("昨日支付金额：" + data.yesterday);
  }

  // 时间显示
  function clock() {
    var date = new Date();
    var year = date.getFullYear() + ".",
      month = date.getMonth() + 1 + ".",
      day = date.getDate(),
      hour = date.getHours() < 10 ? "0" + date.getHours() + ":" : date.getHours() + ":",
      minute = date.getMinutes() < 10 ? "0" + date.getMinutes() + ":" : date.getMinutes() + ":",
      second = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
      $('.time').html(year + month + day + '&nbsp;' + hour + minute + second);
  }
  // 本月业绩TOP5
  function Top5(data) {
    $(".top5Content").empty();
    if (data.length != 0) {
      var item = '<p style="color: white; margin-left: 60px; font-size: 14px; font-weight: lighter; margin-top: 15px"></p>';
      for (var i = 0; i < data.length; i++) {
        $(".top5Content").append(item);
        $($(".top5Content").find("p")[i]).html('TOP' + Number(i+1) + '&nbsp;&nbsp;' + data[i]);
      }
    }
  }
  
  // 代理累计业绩排行榜
  function totalAmount(data) {
    var amountItem = '<p style="color: white; margin-left: 20px; font-size: 13px; font-weight: lighter; margin-top: 11px"></p>';
    for (var i = 0; i < data.length; i++) {
      $(".amountContent").append(amountItem);
      $($(".amountContent").find("p")[i]).html('<span style="color:#ffce37">NO${i+1}</span>' + '&nbsp;&nbsp;${parseInt(data[i].money)}元' + '<span style="float: right; margin-right: 35px">${data[i].user_name}(${data[i].mobile})<span>');
    }
  }

  // 实时订单信息
  var lastItem = '';
  function timelyOrder(data) {
    var tmp = data[data.length - 1];
    var lastIndex = data.indexOf(lastItem);
    lastItem = tmp;
    data = data.filter(function(item, index){
      return index > lastIndex; 
    });
    if (data.length != 0) {
      
      for (var i = 0; i < data.length; i++) {
        var newItem = '<li style="height: 36px; margin: 0;"><p style="color: white;">${data[i]}</p></li>';
        $(".timelyContent ul").prepend(newItem);
      }
      var count = $(".timelyContent ul li").length;
      var scrollHeight = (6 - count) * 35;
      if (count < 6) {
        $('.timelyContent').animate({
          bottom: scrollHeight + 'px'
        }, 500)
      } else {
        scrollHeight = (count - 6) * 35;
        $('.timelyContent').animate({
          bottom: -(scrollHeight - 15) +'px'
        }, 500, function() {
          $('.timelyContent').css({
            bottom: 0
          })
          for (var j = 0; j < count - 6; j++) {
            $('.timelyContent ul li:last').remove();
          }
        });
      }
    }
  }
  //设置logo标题
  function getInfo(data) {
    $('#title img').attr('src',res.data.info.logo);
        $('#title span').html(res.data.info.title);
   }
  // 代理加入趋势
  function joinOption(data) {
    var option = {
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          lineStyle: {
            color: '#2684b1'
          }
        }
      },
      grid: {
        show: true,
        backgroundColor: 'rgba(3, 52, 94, 0.88)',
        borderColor: '#2684b1',
        borderWidth: 2,
      },
      xAxis: {
        boundaryGap: false,
        axisLine: {
          show: false
        },
        axisTick: {
          length: 0
        },
        axisLabel: {
          textStyle: {
            color: '#2dd8d3',
            fontSize: 12
          }
        },
        splitLine: {
          show: true,
          interval: 0, 
          lineStyle: {
            color: 'rgba(38, 133, 180, 0.3)'
          }
        },
        data: data.name,
      },
      yAxis: {
        type: 'value',
        boundaryGap: false,
        minInterval: 1,
        axisLine: {
          show: false
        },
        axisTick: {
          length: 0
        },
        axisLabel: {
          interval: 2,
          textStyle: {
            color: '#2dd8d3',
            fontSize: 12
          }
        },
        splitLine: {
          show: true,
          interval: 0,
          lineStyle: {
            color: 'rgba(38, 133, 180, 0.3)'
          }
        },
      },
      series: [{
        name: '加入数量',
        type: 'line',
        itemStyle: {
          normal: {
            color: '#2dd8d3',
            lineStyle: {
              color: '#2dd8d3',
            },
            areaStyle: {
              color: 'rgba(3, 52, 94, 0.88)'
            }
          }
        },
        areaStyle: {
          normal: {
            color: '#fff',
            opacity: 0
          }
        },
        showSymbol: true,
        symbol: 'circle',
        symbolSize: 10,
        showAllSymbol: true,
        hoverAnimation: true,
        data: data.value
      }]
    };
    return option;
  }
  // 代理进货趋势
  function takeOption(data) {
    var quantityName = "数量", priceName="金额";
    if (Math.max.apply(null, data.total_quantity) > 10000) {
      quantityName = "数量（万）"
      for (var i = 0; i < data.total_quantity.length; i++) {
        data.total_quantity[i] = (Number(data.total_quantity[i]) / 10000).toFixed(6);
      }
    }
    if (Math.max.apply(null, data.total_amount) > 10000) {
      priceName = "金额（万）"
      for (var i = 0; i < data.total_amount.length; i++) {
        data.total_amount[i] = (Number(data.total_amount[i]) / 10000).toFixed(6)
      }
    }
    var option = {
      legend: {
        data: ['数量', '金额'],
        top: 19,
        itemGap: 15,
        itemWidth: 10,
        textStyle: {
          color: '#fff',
        }
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          lineStyle: {
            color: '#2684b1'
          }
        }
      },
      grid: {
        show: true,
        backgroundColor: 'rgba(3, 52, 94, 0.88)',
        borderColor: '#2684b1',
        borderWidth: 2,
        right: '15%',
        left: '15%'
      },
      xAxis: {
        boundaryGap: false,
        axisLine: {
          show: false
        },
        axisTick: {
          length: 0
        },
        axisLabel: {
          textStyle: {
            color: '#2dd8d3',
            fontSize: 12
          }
        },
        splitLine: {
          show: true,
          interval: 0, 
          lineStyle: {
            color: 'rgba(38, 133, 180, 0.3)'
          }
        },
        data: data.date,
      },
      yAxis: [{
        name: quantityName + '　'.repeat(quantityName=="数量" ? 3 : 6),
        position: 'left',
        type: 'value',
        boundaryGap: false,
        minInterval: 1,
        nameGap: 7,
        nameTextStyle: {
          color: '#2dd8d3',
        },
        axisLine: {
          show: false
        },
        axisTick: {
          length: 0
        },
        axisLabel: {
          interval: 2,
          textStyle: {
            color: '#2dd8d3',
            fontSize: 12
          },
        },
        splitLine: {
          show: false,
          lineStyle: {
            color: 'rgba(38, 133, 180, 0.3)'
          }
        },
      }, {
        name: '　'.repeat(priceName=="金额" ? 3 : 6) + priceName,
        position: 'right',
        type: 'value',
        boundaryGap: false,
        nameGap: 7,
        nameTextStyle: {
          color: '#2dd8d3',
        },
        axisLine: {
          show: false
        },
        axisTick: {
          length: 0
        },
        axisLabel: {
          interval: 2,
          textStyle: {
            color: '#2dd8d3',
            fontSize: 12,
          }
        },
        splitLine: {
          show: true,
          interval: 0,
          lineStyle: {
            color: 'rgba(38, 133, 180, 0.3)'
          }
        },
      }],
      series: [{
        name: '数量',
        type: 'line',
        yAxisIndex: 0,
        itemStyle: {
          normal: {
            color: '#2dd8d3',
            lineStyle: {
              color: '#2dd8d3',
            }
          }
        },
        showSymbol: true,
        showAllSymbol: true,
        symbol: 'circle',
        symbolSize: 10,
        hoverAnimation: true,
        data: data.total_quantity
      }, {
        name: '金额',
        type: 'line',
        yAxisIndex: 1,
        itemStyle: {
          normal: {
            color: '#ff7515',
            lineStyle: {
              color: '#ff7515',
            }
          }
        },
        showSymbol: true,
        showAllSymbol: true,
        symbol: 'circle',
        symbolSize: 10,
        hoverAnimation: true,
        data: data.total_amount
      }]
    };
    return option;
  }
    //自适应屏幕
    function resize(){
        var width=window.innerWidth;
        var scale=width/1920;
        document.body.style.transform='scale('+scale+')';
    }
    function adjuest(){
        const Height = document.body.scrollHeight;
        const Width = document.body.clientWidth;
        document.getElementById('map').style.minHeight=1080+'px';
        document.getElementById('map').style.minWidth=1920+'px';
        myChart.resize(Width, Height)
    };
    adjuest()
    resize()
    window.onresize=function(){
        var width=window.innerWidth;
        var scale=width/1920;
        document.body.style.transform='scale('+scale+')';
    }
    //获取search
    function GetQueryString(name){
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
    }
    //判断是否为第一次请求
    var isFrist = 1;
  setInterval(function() {
    clock();
  }, 1000);
  var fnObj = {
    admin_deal: {},
    admin_sales: {},
    agent_achievement: {},
    agent_distribute: {},
    agent_join_trend: {},
    agent_stock_trend: {},
    info: {},
    orders_area_distribute: {},
    performance_top_five: {},
    purchase_team_number: {},
    real_time_orders: {},
    info: {},
    real_time_orders_transport:{}
  };
  var fnCb = {
    admin_deal: function(data) {
      // 统计数据
      statistics(data);
    },
    admin_sales: function(data) {
      salesTrendChart.setOption(salesTrendOption(data));
    },
    agent_achievement: function(data) {
      // 代理累计业绩排行榜 22条数据 totalAmount()
      totalAmount(data);
    },
    agent_distribute: function(data) {
      agentSpreadChart.setOption(agentSpreadOption(data));
    },
    agent_join_trend: function(data) {
      joinChart.setOption(joinOption(data));
    },
    agent_stock_trend: function(data) {
      takeChart.setOption(takeOption(data));
    },
    info: function(data) {
      $('#title img').attr('src', data.logo);
            $('#title span').html(data.title);
    },
    orders_area_distribute: function(data) {
      orderTopChart.setOption(orderTopOption(data));
    },
    performance_top_five: function(data) {
      Top5(data);
    },
    purchase_team_number: function(data) {
      agentTeamChart.setOption(agentTeamOption(data));
    },
    real_time_orders: function(data) {
      timelyOrder(data);
    },
    real_time_orders_transport: function(data){
      myChart.setOption(mapOption(data));
    }
  };

  function changeAjax(res) {
    for (var key in fnObj){
      console.log(key);
      console.log(res.data[key]);
      if(JSON.stringify(fnObj[key]) != JSON.stringify(res.data[key])){
        fnObj[key] = res.data[key];
        fnCb[key](JSON.parse(JSON.stringify(res.data[key].data || res.data[key])));
      }
    }
  }
  setInterval(function(){
        $.ajax({
           url: '<?php echo U("Mp/Echarts/echarts_data_get");?>',
           type: 'POST',
           dataType:'json',
            data: {
              qyuser:'<?php echo ($qyuser); ?>'
            },
            success: function(res) {
              oldData = res.data;
                if(res.status==1){
                    changeAjax(res);
                }else if(res.status==-1){
                  http://localhost/Kangli/Mp/Login/index
                    location.href='/screen/login.html?admin_id='+GetQueryString('admin_id');
                }else{
                    layer.msg(res.msg);
                }
                
            },
            error: function(){
                layer.msg('操作失败请刷新再试');
            }
        })
    },2000);
</script>
</body></html>