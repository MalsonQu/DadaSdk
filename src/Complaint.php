<?php
/**
 * Created by PhpStorm.
 * User: Malson
 * Date: 2017/11/10
 * Time: 上午8:12
 */
namespace DadaSdk;

class Complaint extends Dada
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
     * 商家投诉达达
     *
     * @param string $order_id  第三方订单编号
     * @param string $reason_id 投诉原因ID
     *
     * @return array|bool
     */
    function dada ( $order_id , $reason_id )
    {
        $data = [
            'order_id'  => $order_id ,
            'reason_id' => $reason_id ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/complaint/dada' , $data );
    }

    /**
     * 获取商家投诉达达原因
     *
     * @return array|bool
     */
    function reasons ()
    {
        return Request::getHttpRequestWithPost( self::getLink() . '/api/complaint/reasons' );
    }
}