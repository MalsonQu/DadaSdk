<?php
/**
 * Created by PhpStorm.
 * User: Malson
 * Date: 2017/11/9
 * Time: 上午10:03
 */
namespace DadaSdk;

class Dada
{
    // +----------------------------------------------------------------------
    // | 定义
    // +----------------------------------------------------------------------
    
    // 达达的appKey
    static protected $appKey = '';
    // 达达的appSecret
    static protected $appSecret = '';
    // 当前环境 formal = 正式 , test = 测试
    static protected $conditions = '';
    // 正式环境地址
    static protected $linkForFormal = 'http://newopen.imdada.cn';
    // 测试环境地址
    static protected $linkForTest = 'http://newopen.qa.imdada.cn';
    // 正式环境商户ID
    static protected $sourceIdForFormal = '';
    // 测试环境商户ID
    static protected $sourceIdForTest = '73753';
    // 正式环境门店编码
    static protected $shopNoForFormal = '';
    // 测试环境门店编码
    static protected $shopNoForTest = '11047059';

    /**
     * Dada constructor.
     *
     * @param string $appKey     达达appKey
     * @param string $appSecret  达达appSecret
     * @param string $sourceId   达达商户ID
     * @param string $shopNo     达达门店编码
     * @param string $conditions 代码运行环境
     */
    function __construct ( $appKey = '' , $appSecret = '' , $sourceId = '' , $shopNo = '' , $conditions = 'test' )
    {
        if ( !empty( $appKey ) )
        {
            self::$appKey = $appKey;
        }
        if ( !empty( $appSecret ) )
        {
            self::$appSecret = $appSecret;
        }
        if ( !empty( $sourceId ) )
        {
            self::$sourceIdForFormal = $sourceId;
        }
        if ( !empty( $shopNo ) )
        {
            self::$shopNoForFormal = $shopNo;
        }

        // 设置当前环境
        self::$conditions = $conditions;
    }

    /**
     * 设置当前环境
     *
     * @param string $conditions
     */
    public static function setConditions ( $conditions )
    {
        self::$conditions = $conditions;
    }

    /**
     * 设置正式环境商户ID
     *
     * @param string $sourceIdForFormal
     */
    public static function setSourceIdForFormal ( $sourceIdForFormal )
    {
        self::$sourceIdForFormal = $sourceIdForFormal;
    }

    /**
     * 设置正式环境门店编码
     *
     * @param string $shopNoForFormal
     */
    public static function setShopNoForFormal ( $shopNoForFormal )
    {
        self::$shopNoForFormal = $shopNoForFormal;
    }
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
     * 获取公共参数
     *
     * @param array|string $data 业务参数
     *
     * @param null|string  $sourceID
     *
     * @return array
     */
    static protected function getCommonParam ( $data = [] , $sourceID = NULL )
    {
        $_arr = [
            'app_key'   => self::$appKey ,
            'timestamp' => time() ,
            'format'    => 'json' ,
            'v'         => '1.0' ,
            'source_id' => isset( $sourceID ) ? $sourceID : self::getSourceID() ,
            'body'      => empty( $data ) ? '' : json_encode( $data ) ,
        ];

        return $_arr;
    }

    /**
     * 获取 门店ID 自动判断 环境
     * @return string
     */
    static protected function getShopNo ()
    {
        return self::$conditions === 'formal' ? self::$shopNoForFormal : self::$shopNoForTest;
    }

    /**
     * 获取 商户ID 自动判断 环境
     * @return string
     */
    static protected function getSourceID ()
    {
        return self::$conditions === 'formal' ? self::$sourceIdForFormal : self::$sourceIdForTest;
    }

    /**
     * 获取 api地址 自动判断 环境
     * @return string
     */
    static protected function getLink ()
    {
        return self::$conditions === 'formal' ? self::$linkForFormal : self::$linkForTest;
    }

    /**
     * 获取充值链接
     *
     * @param double $amount 充值金额（单位元，可以精确到分）
     * @param array  $other  支付成功后跳转的页面（支付宝在支付成功后可以跳转到某个指定的页面，微信支付不支持）
     *
     * @return array|bool
     */
    function recharge ( $amount , $other = [] )
    {
        $data = [
            'amount' => $amount ,
        ];

        $data = array_merge( $other , $data );

        return Request::getHttpRequestWithPost( self::getLink() . '/api/recharge' , $data );
    }

}
