<?php
/**
 * Created by PhpStorm.
 * User: Malson
 * Date: 2017/11/9
 * Time: 上午10:07
 */
namespace DadaSdk;

class Sign extends Dada
{

    // +----------------------------------------------------------------------
    // | 定义
    // +----------------------------------------------------------------------

    // +----------------------------------------------------------------------
    // | 绑定
    // +----------------------------------------------------------------------

    // +----------------------------------------------------------------------
    // | 获取器
    // +----------------------------------------------------------------------

    // +----------------------------------------------------------------------
    // | 方法
    // +----------------------------------------------------------------------

    /**
     * 生成 签名
     *
     * @param array $arr       需要签名的数组
     * @param bool  $buildJson 是否将返回结果转换为JSON数据
     *
     * @return string|array     签名后的内容
     */
    static function buildSign ( $arr , $buildJson = TRUE )
    {
        $_tmpArr = $arr;

        // 第一步：将参与签名的参数按照键值(key)进行字典排序
        ksort( $_tmpArr );
        // 第二步：将排序过后的参数，进行key和value字符串拼接
        $_string = '';
        foreach ( $_tmpArr as $__key => $__value )
        {
            $_string .= $__key . $__value;
        };

        // 第三步：将拼接后的字符串首尾加上app_secret秘钥，合成签名字符串
        $_string = self::$appSecret . $_string . self::$appSecret;

        // 第四步：对签名字符串进行MD5加密，生成32位的字符串
        // 第五步：将签名生成的32位字符串转换为大写
        $_string = strtoupper( md5( $_string ) );

        // 拼接
        $arr['signature'] = $_string;

        if ( $buildJson )
        {
            $arr = json_encode( $arr );
        }

        return $arr;
    }

    /**
     * 验证回调签名
     *
     * @param string $arr 需要验证签名的数组
     *
     * @return array
     */
    static function verifySign ( $arr )
    {
        $arr = json_decode( $arr , TRUE );

        $_tmpArr = [
            'client_id'   => $arr['client_id'] ,
            'order_id'    => $arr['order_id'] ,
            'update_time' => $arr['update_time'] ,
        ];

        // 第一步：将参与签名的字段的值进行升序排列
        sort( $_tmpArr );

        // 将排序过后的参数，进行字符串拼接
        $_string = '';
        foreach ( $_tmpArr as $__key => $__value )
        {
            $_string .= $__value;
        };

        // 第三步：对第二步连接的字符串进行md5加密
        $_string = md5( $_string );

        return $_string === $arr['signature'] ? [ 'status' => TRUE , 'result' => $arr ] : [
            'status' => FALSE ,
            'msg'    => '签名验证失败' ,
        ];
    }

}