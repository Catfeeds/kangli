<?php
class Verifyzx {
    protected $config =	array(
        'useZh'     =>  false,           // 使用中文验证码 
        'useCurve'  =>  true,            // 是否画混淆曲线
        'useNoise'  =>  true,            // 是否添加杂点	
        'imageH'    =>  0,               // 验证码图片高度
        'imageW'    =>  0,               // 验证码图片宽度
        'fontttf'   =>  '', // 字体
        'fontttfarr'   =>  array(1=>'1.ttf',2=>'2.ttf',3=>'3.ttf',4=>'4.ttf',5=>'5.ttf'), // 可选字体
        'color'        =>  array(1=>array('0','0','0'),2=>array('223','0','35'),3=>array('0','159','60'),4=>array('227','0','122'),5=>array('0','168','235')), // 可选颜色
        'color2'       =>  array(1=>array('183','183','183'),2=>array('238','124','107'),3=>array('131','199','93'),4=>array('197','124','172'),5=>array('110','195','201')), // 可选颜色2 浅色
        'bg'           =>  array(255, 255, 255),  // 背景颜色
        'codearr'      =>  array(),  // 验证码字符数组
        'linesarr'     =>  array(),  // 干扰线数组
        'noisearr'     =>  array(),  // 杂点数组
        'img_path'     =>  '',  // 
        );

    private $_image   = NULL;     // 验证码图片实例
    private $_color   = NULL;     // 颜色

    /**
     * 架构方法 设置参数
     * @access public     
     * @param  array $config 配置参数
     */    
    public function __construct($config=array()){
        $this->config   =   array_merge($this->config, $config);
    }

    /**
     * 使用 $this->name 获取配置
     * @access public     
     * @param  string $name 配置名称
     * @return multitype    配置值
     */
    public function __get($name) {
        return $this->config[$name];
    }

    /**
     * 设置验证码配置
     * @access public     
     * @param  string $name 配置名称
     * @param  string $value 配置值     
     * @return void
     */
    public function __set($name,$value){
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     * 检查配置
     * @access public     
     * @param  string $name 配置名称
     * @return bool
     */
    public function __isset($name){
        return isset($this->config[$name]);
    }


    /**
     * 生成验证图
     * @access public     
     * @return void
     */
    public function entry() {
        // 图片宽(px)
        $this->imageW;
        // 图片高(px)
        $this->imageH;
        // 建立一幅 $this->imageW x $this->imageH 的图像
        $this->_image = imagecreate($this->imageW, $this->imageH); 
        // 设置背景色      
        imagecolorallocate($this->_image, $this->bg[0], $this->bg[1], $this->bg[2]); 

        // 验证码使用字体目录 
        $ttfPath = dirname(__FILE__) . '/' . ($this->useZh ? 'zhttfs' : 'ttfs') . '/';

        // 绘杂点
        if ($this->useNoise) {
            $this->_writeNoise();
        } 
        // 绘干扰线
        if ($this->useCurve) {
            foreach($this->linesarr as $k=>$v){
                $this->_writeCurve($v);
            }
        }


        // 绘验证码

        foreach($this->codearr as $k=>$v){
            $this->fontttf = $ttfPath . $this->fontttfarr[$v['fontttf']];
            $this->_color = imagecolorallocate($this->_image, $this->color[$v['color']][0], $this->color[$v['color']][1], $this->color[$v['color']][2]);
            imagettftext($this->_image, $v['fontsize'], $v['angle'], $v['x'], $v['y'], $this->_color, $this->fontttf, $v['text']);
        }

        
                        
        //header('Cache-Control: private, max-age=0, no-store, no-cache, must-revalidate');
        //header('Cache-Control: post-check=0, pre-check=0', false);		
        //header('Pragma: no-cache');
        //header("content-type: image/png");

        // 输出图像
        imagepng($this->_image,$this->img_path);
        imagedestroy($this->_image);
    }

    /** 
     * 画一条由两条连在一起构成的随机正弦函数曲线作干扰线(你可以改成更帅的曲线函数) 
     *      
     *      高中的数学公式咋都忘了涅，写出来
     *		正弦型函数解析式：y=Asin(ωx+φ)+b
     *      各常数值对函数图像的影响：
     *        A：决定峰值（即纵向拉伸压缩的倍数）
     *        b：表示波形在Y轴的位置关系或纵向移动距离（上加下减）
     *        φ：决定波形与X轴位置关系或横向移动距离（左加右减）
     *        ω：决定周期（最小正周期T=2π/∣ω∣）
     *
     */
    private function _writeCurve($line) {

        $px = $py = 0;
        
        // 曲线前部分
        $A = $line['zf'];                  // 振幅
        $b = $line['ypy'];   // Y轴方向偏移量
        $f = $line['xpy'];   // X轴方向偏移量
        $T = $line['zq'];  // 周期
        $w = (2* M_PI)/$T;  //M_PI 3.14
                        
        $px1 = $line['xb'];  // 曲线横坐标起始位置
        $px2 = $line['xe'];  // 曲线横坐标结束位置
        $this->_color = imagecolorallocate($this->_image, $this->color2[$line['color']][0], $this->color2[$line['color']][1], $this->color2[$line['color']][2]);
        for ($px=$px1; $px<=$px2; $px = $px + 1) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + $this->imageH/2;  // y = Asin(ωx+φ) + b
                $i = 1; //线的大小
                while ($i > 0) {	
                    imagesetpixel($this->_image, $px + $i , $py + $i, $this->_color);  // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多				
                    $i--;
                }
            }
        }
        
        // 曲线后部分
        $A = $line['zf2'];                  // 振幅		
        $f = $line['xpy2'];  // X轴方向偏移量
        $T = $line['zq2']; // 周期
        $w = (2* M_PI)/$T;		
        $b = $py - $A * sin($w*$px + $f) - $this->imageH/2;
        $px1 = $px2;
        $px2 = $line['xe2'];

        for ($px=$px1; $px<=$px2; $px=$px+ 1) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + $this->imageH/2;  // y = Asin(ωx+φ) + b
                $i = 1;//线的大小
                while ($i > 0) {			
                    imagesetpixel($this->_image, $px + $i, $py + $i, $this->_color);	
                    $i--;
                }
            }
        }
    }

    /**
     * 画杂点
     * 往图片上写不同颜色的字母或数字
     */
    private function _writeNoise() {
        foreach($this->noisearr as $k=>$v){
            //杂点颜色
            $noiseColor = imagecolorallocate($this->_image,$this->color2[$v['color']][0],$this->color2[$v['color']][1], $this->color2[$v['color']][2]);

            // 绘杂点
            imagestring($this->_image, 5, $v['x'],  $v['y'], $v['txt'], $noiseColor);
           
        }
    }


}
