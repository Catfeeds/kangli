<?php
namespace Klapi\Common\Util;
class McryptAES
{
    /**
     * var string $method 加解密方法，可通过openssl_get_cipher_methods()获得
     */
    protected $method;

    /**
     * var string $secret_key 加解密的密钥
     */
    protected $secret_key;

    /**
     * var string $iv 加解密的向量，有些方法需要设置比如CBC
     */
    protected $iv;

    /**
     * var string $options （不知道怎么解释，目前设置为0没什么问题）
     */
    protected $options; 

    /**
     * 构造函数
     *
     * @param string $key 密钥
     * @param string $method 加密方式
     * @param string $iv iv向量
     * @param mixed $options 还不是很清楚 
     *
     */
    public function __construct($key,$iv ='',$method = 'AES-128-ECB')
    {
        // key是必须要设置的
        // $this->secret_key = isset($key) ?hash('md5',$key,true): exit('key为必须项');
        $this->secret_key = isset($key)?$key: exit('key为必须项');
        $this->iv = substr($iv.'0000000000000000', 0,16);//可以忽略这一步，只要你保证iv长度是16
        $this->method = $method;
    }

 	/**
     * 加密
     * @param string $data   待加密的数据
     */
    public function encrypt($data) {
         
        $data=$this->PKCS7Padding($data);
        $result=mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$this->secret_key,$data,MCRYPT_MODE_CBC,$this->iv);
        //return base64_encode($result);
        $result=bin2hex($result);
        return $result;
    }
     
    /**
     * 解密
     * @param string $data   待解密的数据
     */
    public function decrypt($data) {
        $data=pack('H*',$data);
        //$data=base64_decode($data);
        $result=mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->secret_key,$data,MCRYPT_MODE_CBC,$this->iv);
        $result=$this->UnPKCS7Padding($result);
        return $result;
    }

    /**
	 * 为字符串添加PKCS7 Padding
	 * @param string $str   源字符串 
	 */
	public function PKCS7Padding($str) {
		$block=mcrypt_get_block_size(MCRYPT_RIJNDAEL_128,'cbc');
		$text_length = strlen($str);
		//计算需要填充的位数
		$amount_to_pad = $block - ($text_length % $block);
		if ($amount_to_pad == 0) {
			$amount_to_pad = $block;
		}
		//获得补位所用的字符
		$pad_chr = chr($amount_to_pad);
		$tmp = "";
		for ($index = 0; $index < $amount_to_pad; $index++) {
			$tmp .= $pad_chr;
		}
		return $str . $tmp;
	}
	 
	/**
	 * 去除字符串末尾的PKCS7 Padding
	 * @param string $str    带有Padding字符的字符串
	 */
	public function UnPKCS7Padding($str) {
		$pad = ord(substr($str, -1));
		if ($pad < 1 || $pad > 32) {
			$pad = 0;
		}
		return substr($str, 0, (strlen($str) - $pad));
		
	}
}