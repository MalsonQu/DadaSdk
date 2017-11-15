<?php
/**
 * Created by PhpStorm.
 * User: Malson
 * Date: 2017/11/9
 * Time: 下午4:50
 */
namespace DadaSdk;

class Shop extends Dada
{
    // +----------------------------------------------------------------------
    // | 方法
    // +----------------------------------------------------------------------

    /**
     * 注册商户
     *
     * @param string $mobile             注册商户手机号,用于登陆商户后台
     * @param string $city_name          商户城市名称(如,上海)
     * @param string $enterprise_name    企业全称
     * @param string $enterprise_address 企业地址
     * @param string $contact_name       联系人姓名
     * @param string $contact_phone      联系人电话
     * @param string $email              邮箱地址
     *
     * @return array|bool
     */
    function merchantAdd ( $mobile , $city_name , $enterprise_name , $enterprise_address , $contact_name , $contact_phone , $email )
    {
        $data = [
            'mobile'             => $mobile ,
            'city_name'          => $city_name ,
            'enterprise_name'    => $enterprise_name ,
            'enterprise_address' => $enterprise_address ,
            'contact_name'       => $contact_name ,
            'contact_phone'      => $contact_phone ,
            'email'              => $email ,
        ];

        return Request::getHttpRequestWithPost( self::getLink() . '/merchantApi/merchant/add' , $data );
    }

    /**
     * 新增门店
     *
     * @param array $station_name
     * @param array $business
     * @param array $city_name
     * @param array $area_name
     * @param array $station_address
     * @param array $lng
     * @param array $lat
     * @param array $contact_name
     * @param array $phone
     * @param array $other 其他非必填信息
     *
     * @return array|bool
     */
    function add ( $station_name , $business , $city_name , $area_name , $station_address , $lng , $lat , $contact_name , $phone , $other = [] )
    {
        $data = [];
        for ( $i = 0; $i < count( $station_name ); $i++ )
        {
            $data[ $i ] = [
                'station_name'    => $station_name[ $i ] ,
                'business'        => $business[ $i ] ,
                'city_name'       => $city_name[ $i ] ,
                'area_name'       => $area_name[ $i ] ,
                'station_address' => $station_address[ $i ] ,
                'lng'             => $lng[ $i ] ,
                'lat'             => $lat[ $i ] ,
                'contact_name'    => $contact_name[ $i ] ,
                'phone'           => $phone[ $i ] ,
            ];
            if ( !empty( $other ) )
            {
                $data[ $i ] = array_merge( $other[ $i ] , $data[ $i ] );
            }
        }


        return Request::getHttpRequestWithPost( self::getLink() . '/api/shop/add' , $data );
    }

    /**
     * 编辑门店
     *
     * @param string $origin_shop_id 门店编码
     * @param array  $other          其他非必填信息
     *
     * @return array|bool
     */
    function update ( $origin_shop_id , $other = [] )
    {
        $data = [
            'origin_shop_id' => $origin_shop_id ,
        ];

        $data = array_merge( $other , $data );

        return Request::getHttpRequestWithPost( self::getLink() . '/api/shop/update' , $data );
    }

    /**
     * 门店详情
     *
     * @param string $origin_shop_id 门店编码
     * @param array  $other          其他非必填信息
     *
     * @return array|bool
     */
    function detail ( $origin_shop_id , $other = [] )
    {
        $data = [
            'origin_shop_id' => $origin_shop_id ,
        ];

        $data = array_merge( $other , $data );

        return Request::getHttpRequestWithPost( self::getLink() . '/api/shop/detail' , $data );
    }
}