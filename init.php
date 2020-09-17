<?php
/*
 * Plugin Name:  WPYAA's Alipay Wechat(微信 支付宝) for WooCommerce
 * Plugin URI: https://www.wpyaa.com/product/2.html
 * Description: WooCommerce 微信支付(支持：PC电脑端、手机浏览器、微信客户端)支付+退款，支付宝(支持：PC电脑端、手机浏览器)支付+退款
 * Author: 板鸭WordPress
 * Version: 1.0.0
 * Author URI: https://www.wpyaa.com
 * WC tested up to: 9.9.9
 */
defined( 'ABSPATH' ) || exit;

defined('WPYAA_WC_AW_FILE')||define('WPYAA_WC_AW_FILE',__FILE__);

require_once 'wc-patch.php';

if(!function_exists('wpyaa_wc_aw_plugin_action_links')){
    /**
     * 配置插件的菜单
     * @param array $links
     * @return array
     */
    function wpyaa_wc_aw_plugin_action_links($links){
        return array_merge ( array (
            'settings_wechat' => '<a href="' . admin_url ( 'admin.php?page=wc-settings&tab=checkout&section=wpyaa_wc_aw_wechat' ) . '">微信</a>',
            'settings_alipay' => '<a href="' . admin_url ( 'admin.php?page=wc-settings&tab=checkout&section=wpyaa_wc_aw_alipay' ) . '">支付宝</a>'
        ), $links );
    }
}
add_filter ( 'plugin_action_links_'.plugin_basename( WPYAA_WC_AW_FILE ),'wpyaa_wc_aw_plugin_action_links',10,1 );

/**
 * 注册页面路由
 */
if(!function_exists('wpyaa_wc_aw_rest_api_init')){
    function wpyaa_wc_aw_rest_api_init(){
        require_once 'controller/abstract-wrest-controller.php';
        require_once 'controller/class-alipay-controller.php';
        require_once 'controller/class-wechat-controller.php';

        require_once 'response/class-redirect-response.php';
        require_once 'response/class-content-response.php';
        require_once 'response/class-view-response.php';

        (new Wpyaa_WC_AW_Alipay_Controller())->register_routes();
        (new Wpyaa_WC_AW_Wechat_Controller())->register_routes();
    }
}

add_action('rest_api_init','wpyaa_wc_aw_rest_api_init');

/**
 * 初始化支付网关
 */
if(!function_exists('wpyaa_wc_aw_woocommerce_init')){
    function wpyaa_wc_aw_woocommerce_init(){
        require_once 'alipay.php';
        require_once 'wechat.php';

        Wpyaa_WC_AW_Alipay::instance();
        Wpyaa_WC_AW_Wechat::instance();
    }
}

add_action('woocommerce_init','wpyaa_wc_aw_woocommerce_init');