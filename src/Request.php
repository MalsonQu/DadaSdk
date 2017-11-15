<?php
/**
 * Created by PhpStorm.
 * User: Malson
 * Date: 2017/11/9
 * Time: 上午10:07
 */
namespace DadaSdk;

class Request extends Dada
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
     * 请求接口
     *
     * @param string $url  接口连接地址
     * @param array  $data 接口数据
     *
     * @return array|bool 如果返回 False 则为curl请求失败,否则为业务逻辑
     *                    status=>true/false    表示业务逻辑是否请求成功
     *                    result=>数组           只有业务逻辑为true时才会有此字段,内容为业务返回信息
     *                    msg=>字符串            只有业务逻辑为false时才会出现此字段,内容为错误信息
     */
    static function getHttpRequestWithPost ( $url , $data = [] )
    {
        // json
        $headers = [
            'Content-Type: application/json' ,
        ];
        $curl    = curl_init( $url );

        $data = Sign::buildSign( self::getCommonParam( $data ) );

        curl_setopt( $curl , CURLOPT_URL , $url );
        curl_setopt( $curl , CURLOPT_HEADER , FALSE );
        curl_setopt( $curl , CURLOPT_POST , TRUE );
        curl_setopt( $curl , CURLOPT_RETURNTRANSFER , TRUE );
        curl_setopt( $curl , CURLOPT_POSTFIELDS , $data );
        curl_setopt( $curl , CURLOPT_TIMEOUT , 3 );
        curl_setopt( $curl , CURLOPT_HTTPHEADER , $headers );
        $resp = curl_exec( $curl );
//        var_dump( curl_error( $curl ) );//如果在执行curl的过程中出现异常，可以打开此开关查看异常内容。
        $info = curl_getinfo( $curl );
        curl_close( $curl );

        if ( isset( $info['http_code'] ) && $info['http_code'] == 200 )
        {
            return self::buildReturn( $resp );
        }

        return FALSE;
    }

    /**
     * 生成返回数据
     *
     * @param array $data 达达平台返回的信息
     *
     * @return array 生成好的数据
     */
    static private function buildReturn ( $data )
    {
        $data = json_decode( $data , TRUE );

        if ( $data['status'] === 'success' )
        {
            return [
                'status' => TRUE ,
                'result' => $data['result'] ,
            ];
        }
        else
        {
            return [
                'status' => FALSE ,
                'msg'    => $data['msg'] ,
            ];
        }
    }

}