<?php
namespace app\klapi\libs;
class OpenSSLAES
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
    protected $aesIV;

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
    public function __construct($key,$iv = '',$method = 'AES-128-CBC')
    {
        // key是必须要设置的
        // $this->secret_key = isset($key) ?hash('md5',$key,true): exit('key为必须项');
        $this->secret_key = isset($key)?$key: exit('key为必须项');

        // $this->aesIV = substr($iv.'0000000000000000', 0,16);//可以忽略这一步，只要你保证iv长度是16
        $this->aesIV =$iv;//可以忽略这一步，只要你保证iv长度是16

        $this->method = $method;
    }

    /**
     * 加密方法，对数据进行加密，返回加密后的数据
     *
     * @param string $data 要加密的数据
     * 
     * @return string 
     *
     */
    public function encrypt($data)
    {
        return urlencode(openssl_encrypt($data,$this->method,$this->secret_key,OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,$this->aesIV));
    }

    /**
     * 解密方法，对数据进行解密，返回解密后的数据
     *
     * @param string $data 要解密的数据
     * 
     * @return string 
     *
     */
    public function decrypt($data)
    {
        // return openssl_decrypt(urldecode($data),$this->method,$this->secret_key,false,$this->iv);

        try {
            //解密
            $decrypted = openssl_decrypt(base64_decode($data),$this->method,$this->secret_key,OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,$this->aesIV);
            var_dump($decrypted);
        } catch (\Exception $e) {
            var_dump($data);
            var_dump($this->secret_key);
            var_dump($this->aesIV);
            return false;
        }
        // try {
        //     //去除补位字符
        //     $pkc_encoder = new PKCS7Encoder;
        //     $result = $pkc_encoder->decode($decrypted);
        // } catch (\Exception $e) {
        //     //print $e;
        //     return false;
        // }
        return $decrypted;
    }
}