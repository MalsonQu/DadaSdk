<?php
/**
 * Created by PhpStorm.
 * User: Malson
 * Date: 2017/11/9
 * Time: 下午12:37
 */
namespace DadaSdk;

class Order extends Dada
{

    // +----------------------------------------------------------------------
    // | 定义
    // +----------------------------------------------------------------------

    // +----------------------------------------------------------------------
    // | 绑定
    // +----------------------------------------------------------------------

    // +----------------------------------------------------------------------
    // | 获取
    // +----------------------------------------------------------------------

    /**
     * 获取取消原因
     * @return array|bool
     */
    function cancelReasons ()
    {
        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/cancel/reasons' );
    }

    /**
     * 获取城市信息
     * @return array|bool
     */
    function cityCodeList ()
    {
        return Request::getHttpRequestWithPost( self::getLink() . '/api/cityCode/list' );
    }

    /**
     * 查询追加配送员
     *
     * @param string $shop_no 门店编码
     *
     * @inheritdoc 可追加的配送员需符合以下条件:
     *              1. 配送员在1小时内接过此商户的订单,且订单未完成
     *              2. 配送员在当前商户接单数小于系统限定的指定商户接单总数
     *              3. 配送员在达达平台的接单数量未达上限
     *
     * @return array|bool
     */
    function appointListTransporter ( $shop_no )
    {
        $data = [
            'shop_no' => $shop_no ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/appoint/list/transporter' , $data );
    }

    // +----------------------------------------------------------------------
    // | 方法
    // +----------------------------------------------------------------------

    /**
     * 新增订单
     *
     * @param string  $orgin_id            第三方订单ID
     * @param string  $city_code           订单所在城市的code
     * @param Double  $cargo_price         订单金额
     * @param Integer $is_prepay           是否需要垫付 1:是 0:否 (垫付订单金额，非运费)
     * @param string  $expected_fetch_time 期望取货时间（1.时间戳,以秒计算时间，即unix-timestamp; 2.该字段的设定，不会影响达达正常取货; 3.订单待接单时,该时间往后推半小时后，会自动被系统取消;4.建议取值为当前时间往后推10~15分钟）
     * @param string  $receiver_name       收货人姓名
     * @param string  $receiver_address    收货人地址
     * @param Double  $receiver_lat        收货人地址维度（高德坐标系）
     * @param Double  $receiver_lng        收货人地址经度（高德坐标系）
     * @param String  $receiver_phone      收货人手机号（手机号和座机号必填一项）
     * @param String  $receiver_tel        收货人座机号（手机号和座机号必填一项）
     * @param String  $callback            回调URL
     * @param array   $other               其他非必填信息 数组
     *
     * @return array
     */
    function addOrder ( $orgin_id , $city_code , $cargo_price , $is_prepay , $expected_fetch_time , $receiver_name , $receiver_address , $receiver_lat , $receiver_lng , $receiver_phone = NULL , $receiver_tel = NULL , $callback , $other = [] )
    {
        $_array = [
            'shop_no'             => self::getShopNo() ,
            'origin_id'           => $orgin_id ,
            'city_code'           => $city_code ,
            'cargo_price'         => $cargo_price ,
            'is_prepay'           => $is_prepay ,
            'expected_fetch_time' => $expected_fetch_time ,
            'receiver_name'       => $receiver_name ,
            'receiver_address'    => $receiver_address ,
            'receiver_lat'        => $receiver_lat ,
            'receiver_lng'        => $receiver_lng ,
            'callback'            => $callback ,
        ];

        if ( !isset( $receiver_phone ) && !isset( $receiver_tel ) )
        {
            return [
                'status' => FALSE ,
                'mes'    => '手机号和座机号必填一项' ,
            ];
        }
        else
        {
            if ( isset( $receiver_phone ) )
            {
                $_array['receiver_phone'] = $receiver_phone;
            }
            else
            {
                $_array['receiver_tel'] = $receiver_tel;
            }
        }

        $_array = array_merge( $other , $_array );

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/addOrder' , $_array );
    }

    /**
     * 重新发布订单
     *
     * @param string  $orgin_id            第三方订单ID
     * @param string  $city_code           订单所在城市的code
     * @param Double  $cargo_price         订单金额
     * @param Integer $is_prepay           是否需要垫付 1:是 0:否 (垫付订单金额，非运费)
     * @param string  $expected_fetch_time 期望取货时间（1.时间戳,以秒计算时间，即unix-timestamp; 2.该字段的设定，不会影响达达正常取货; 3.订单待接单时,该时间往后推半小时后，会自动被系统取消;4.建议取值为当前时间往后推10~15分钟）
     * @param string  $receiver_name       收货人姓名
     * @param string  $receiver_address    收货人地址
     * @param Double  $receiver_lat        收货人地址维度（高德坐标系）
     * @param Double  $receiver_lng        收货人地址经度（高德坐标系）
     * @param String  $receiver_phone      收货人手机号（手机号和座机号必填一项）
     * @param String  $receiver_tel        收货人座机号（手机号和座机号必填一项）
     * @param String  $callback            回调URL
     * @param array   $other               其他非必填信息 数组
     *
     * @return array|bool
     */
    function reAddOrder ( $orgin_id , $city_code , $cargo_price , $is_prepay , $expected_fetch_time , $receiver_name , $receiver_address , $receiver_lat , $receiver_lng , $receiver_phone = NULL , $receiver_tel = NULL , $callback , $other = [] )
    {
        $_array = [
            'shop_no'             => self::getShopNo() ,
            'origin_id'           => $orgin_id ,
            'city_code'           => $city_code ,
            'cargo_price'         => $cargo_price ,
            'is_prepay'           => $is_prepay ,
            'expected_fetch_time' => $expected_fetch_time ,
            'receiver_name'       => $receiver_name ,
            'receiver_address'    => $receiver_address ,
            'receiver_lat'        => $receiver_lat ,
            'receiver_lng'        => $receiver_lng ,
            'callback'            => $callback ,
        ];

        if ( !isset( $receiver_phone ) && !isset( $receiver_tel ) )
        {
            return [
                'status' => FALSE ,
                'mes'    => '手机号和座机号必填一项' ,
            ];
        }
        else
        {
            if ( isset( $receiver_phone ) )
            {
                $_array['receiver_phone'] = $receiver_phone;
            }
            else
            {
                $_array['receiver_tel'] = $receiver_tel;
            }
        }

        $_array = array_merge( $other , $_array );


        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/reAddOrder' , $_array );
    }

    /**
     * 查询订单运费接口
     *
     * @param string  $orgin_id            第三方订单ID
     * @param string  $city_code           订单所在城市的code
     * @param Double  $cargo_price         订单金额
     * @param Integer $is_prepay           是否需要垫付 1:是 0:否 (垫付订单金额，非运费)
     * @param string  $expected_fetch_time 期望取货时间（1.时间戳,以秒计算时间，即unix-timestamp; 2.该字段的设定，不会影响达达正常取货; 3.订单待接单时,该时间往后推半小时后，会自动被系统取消;4.建议取值为当前时间往后推10~15分钟）
     * @param string  $receiver_name       收货人姓名
     * @param string  $receiver_address    收货人地址
     * @param Double  $receiver_lat        收货人地址维度（高德坐标系）
     * @param Double  $receiver_lng        收货人地址经度（高德坐标系）
     * @param String  $receiver_phone      收货人手机号（手机号和座机号必填一项）
     * @param String  $receiver_tel        收货人座机号（手机号和座机号必填一项）
     * @param String  $callback            回调URL
     * @param array   $other               其他非必填信息 数组
     *
     * @return array|bool
     */
    function queryDeliverFee ( $orgin_id , $city_code , $cargo_price , $is_prepay , $expected_fetch_time , $receiver_name , $receiver_address , $receiver_lat , $receiver_lng , $receiver_phone = NULL , $receiver_tel = NULL , $callback , $other = [] )
    {
        $_array = [
            'shop_no'             => self::getShopNo() ,
            'origin_id'           => $orgin_id ,
            'city_code'           => $city_code ,
            'cargo_price'         => $cargo_price ,
            'is_prepay'           => $is_prepay ,
            'expected_fetch_time' => $expected_fetch_time ,
            'receiver_name'       => $receiver_name ,
            'receiver_address'    => $receiver_address ,
            'receiver_lat'        => $receiver_lat ,
            'receiver_lng'        => $receiver_lng ,
            'callback'            => $callback ,
        ];

        if ( !isset( $receiver_phone ) && !isset( $receiver_tel ) )
        {
            return [
                'status' => FALSE ,
                'mes'    => '手机号和座机号必填一项' ,
            ];
        }
        else
        {
            if ( isset( $receiver_phone ) )
            {
                $_array['receiver_phone'] = $receiver_phone;
            }
            else
            {
                $_array['receiver_tel'] = $receiver_tel;
            }
        }

        $_array = array_merge( $other , $_array );


        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/queryDeliverFee' , $_array );
    }

    /**
     * 查询运费后发单接口
     *
     * @param string $deliveryNo 平台订单编号
     *
     * @return array|bool
     */
    function addAfterQuery ( $deliveryNo )
    {
        $_array = [
            'deliveryNo' => $deliveryNo ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/addAfterQuery' , $_array );
    }

    /**
     * 增加小费
     *
     * @param string $order_id  第三方订单编号
     * @param float  $tips      小费金额(精确到小数点后一位，单位：元)
     * @param string $city_code 订单城市区号
     * @param array  $other     其他非必填信息
     *
     * @return array|bool
     */
    function addTip ( $order_id , $tips , $city_code , $other = [] )
    {
        $data = [
            'order_id'  => $order_id ,
            'tips'      => $tips ,
            'city_code' => $city_code ,
        ];

        $data = array_merge( $other , $data );

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/addTip' , $data );
    }

    /**
     * 回调
     *
     * @param $data
     *
     * @return array
     */
    function callback ( $data )
    {
        return Sign::verifySign( $data );
    }

    /**
     * 订单详情查询
     *
     * @param string $order_id 第三方订单ID
     *
     * @return array|bool
     */
    function statusQuery ( $order_id )
    {
        $data = [
            'order_id' => $order_id ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/status/query' , $data );
    }

    /**
     * 取消订单
     *
     * @param string $order_id         第三方订单ID
     * @param string $cancel_reason_id 取消原因ID
     * @param array  $other            其他非必填信息
     *
     * @return array|bool
     */
    function formalCancel ( $order_id , $cancel_reason_id , $other = [] )
    {
        $data = [
            'order_id'         => $order_id ,
            'cancel_reason_id' => $cancel_reason_id ,
        ];

        $data = array_merge( $other , $data );

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/formalCancel' , $data );
    }

    /**
     * 追加订单
     *
     * @param string $order_id       追加的第三方订单ID
     * @param string $transporter_id 追加的配送员ID
     * @param string $shop_no        追加订单的门店编码
     *
     * @return array|bool
     */
    function appointExist ( $order_id , $transporter_id , $shop_no )
    {
        $data = [
            'order_id'       => $order_id ,
            'transporter_id' => $transporter_id ,
            'shop_no'        => $shop_no ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/appoint/exist' , $data );
    }

    /**
     * 取消追加订单
     *
     * @param string $order_id 追加的第三方订单ID
     *
     * @return array|bool
     */
    function appointCancel ( $order_id )
    {
        $data = [
            'order_id' => $order_id ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/api/order/appoint/cancel' , $data );
    }
}