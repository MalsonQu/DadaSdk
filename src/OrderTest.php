<?php
/**
 * Created by PhpStorm.
 * User: Malson
 * Date: 2017/11/9
 * Time: 下午2:31
 * desc: 模拟订单情况
 *
 * !!!!!只能在测试环境使用!!!!!
 */
namespace DadaSdk;

class OrderTest extends Dada
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
     * 接受订单(仅在测试环境供调试使用)
     *
     * @param $order_id
     *
     * @return array|bool
     */
    function accept ( $order_id )
    {
        $data = [
            'order_id' => $order_id ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/accept' , $data );
    }

    /**
     * 完成取货(仅在测试环境供调试使用)
     *
     * @param $order_id
     *
     * @return array|bool
     */
    function fetch ( $order_id )
    {
        $data = [
            'order_id' => $order_id ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/fetch' , $data );
    }

    /**
     * 完成订单(仅在测试环境供调试使用)
     *
     * @param $order_id
     *
     * @return array|bool
     */
    function finish ( $order_id )
    {
        $data = [
            'order_id' => $order_id ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/finish' , $data );
    }

    /**
     * 取消订单(仅在测试环境供调试使用)
     *
     * @param $order_id
     *
     * @param $other
     *
     * @return array|bool
     */
    function cancel ( $order_id ,$other = [])
    {
        $data = [
            'order_id' => $order_id ,
        ];

        $data = array_merge( $other , $data);

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/cancel' , $data );
    }

    /**
     * 订单过期(仅在测试环境供调试使用)
     *
     * @param $order_id
     *
     * @return array|bool
     */
    function expire ( $order_id )
    {
        $data = [
            'order_id' => $order_id ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/expire' , $data );
    }
}