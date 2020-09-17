<?php
/**
 * Created by 小冉(739521119@qq.com).
 * Date: 2020/9/15 22:53
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script type="text/javascript" src="<?php echo home_url('/wp-includes/js/jquery/jquery.js'); ?>"></script>
    <title>微信支付</title>
    <style>
        *{margin:0;padding:0;}
        body{background: #f2f2f4;}
        .clearfix:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
        .clearfix { display: inline-block; }
        * html .clearfix { height: 1%; }
        .clearfix { display: block; }
        .xctitle{height:75px;line-height:75px;text-align:center;font-size:30px;font-weight:300;border-bottom:2px solid #eee;background: #fff;}
        .qrbox{max-width: 900px;margin: 0 auto;padding:85px 20px 20px 50px;}

        .qrbox .left{width: 40%;float: left;display: block;margin: 0px auto;}
        .qrbox .left .qrcon{
            border-radius: 10px;
            background: #fff;
            overflow: visible;
            text-align: center;
            padding-top:25px;
            color: #555;
            box-shadow: 0 3px 3px 0 rgba(0, 0, 0, .05);
            vertical-align: top;
            -webkit-transition: all .2s linear;
            transition: all .2s linear;
        }
        .qrbox .left .qrcon .logo{width: 100%;}
        .qrbox .left .qrcon .title{font-size: 16px;margin: 10px auto;width: 90%;}
        .qrbox .left .qrcon .price{font-size: 22px;margin: 0px auto;width: 100%;}
        .qrbox .left .qrcon .bottom{border-radius: 0 0 10px 10px;width: 100%;background: #32343d;color: #f2f2f2;padding:15px 0px;text-align: center;font-size: 14px;}
        .qrbox .sys{width: 60%;float: right;text-align: center;padding-top:20px;font-size: 12px;color: #ccc}
        .qrbox img{max-width: 100%;}
        @media (max-width : 767px){
            .qrbox{padding:20px;}
            .qrbox .left{width: 90%;float: none;}
            .qrbox .sys{display: none;}
        }
        @media (max-width : 1024px){
            .xcfooter{position: absolute;bottom:10px;left:0;text-align:center;width:100%;font-size:12px;}
        }
    </style>
</head>
<body >
<div class="xctitle">微信支付</div>
<div class="qrbox clearfix">
    <div class="left">
        <div class="qrcon">
            <h5><img src="<?php echo plugins_url('icon/wechat-s.png',WPYAA_WC_AW_FILE);?>" alt="微信支付"></h5>
            <div class="title"><?php echo $order['title'];?></div>
            <div class="price"><?php echo $order['amount'];?></div>
            <div align="center" style="position:relative;">
                <img src="<?php echo $order['pay_url'];?>" style="width: 230px;height: 230px;margin-bottom: 10px;" alt="微信支付" />
            </div>
            <div class="bottom">
                打开微信扫一扫<br/>扫描二维码完成支付
            </div>
        </div>
    </div>
    <div class="sys"><img src="<?php echo plugins_url('icon/wechat-scan-qrcode.png',WPYAA_WC_AW_FILE);?>" alt="微信支付"></div>
</div>
<div class="xcfooter">“<a href="https://www.wpyaa.com">板鸭WordPress</a>”提供技术支持</div>
<script type="text/javascript">
    (function ($) {
        function queryOrderStatus() {
            $.ajax({
                type: 'post',
                url: "<?php echo $order['query_url'];?>",
                timeout:6000,
                cache:false,
                dataType:'json',
                async:true,
                success:function(e){
                    if (e.errcode===0) {
                        location.href = e.url;
                        return;
                    }

                    setTimeout(queryOrderStatus, 2500);
                },
                error:function(e){
                    setTimeout(queryOrderStatus, 2500);
                }
            });
        }
        setTimeout(queryOrderStatus, 3000);
    })(jQuery);
</script>
</body>
</html>
