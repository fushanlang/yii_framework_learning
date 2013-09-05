

// ==UserScript==
// @name 			365jiarun for Firefox
// @namespace		http://www.u-tide.com/fish/
// @description		帮你秒杀的小助手 :-)
// @match			https://www.365jiarun.com/account/*
// @require			https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js
// @icon			http://www.12306.cn/mormhweb/images/favicon.ico
// @run-at			document-idle
// ==/UserScript==


var loginUrl = "/account/login";
var promotionUrl = "/product/promation";
var cartUrl = "/checkout/cart";
var checkoutUrl = "/checkout/checkout"
//-----------------入口----------------------

function entryPoint() {
	var location = window.location;
	var path = location.pathname;

    if (path == loginUrl) {
        //登录页
        loginDo();
    } else if (path == promotionUrl) {
        promotionDo();
    } else if(path == cartUrl){
        cartDo();
    }else if(path == checkoutUrl){
        checkoutDo();
    }
}


function loginDo(){
    $("input.button[type=submit]").val("Test 按钮");
}


function promotionDo(){
    var  temp='<div id="promotion_div" style="float:right;border:solid 1px white">product_id:<input type="text" id="jiarun_product_id" />';
    temp += 'product_option_id:<input type="text" id="jiarun_product_option_id" />';
    temp += 'product_option_value_id:<input type="text" id="jiarun_product_value_option_id" />';
    temp += '<input type="button" id="jiarun_button" class="button jiarun_button" value="start" /> </div>';
    $(".seckill_tit").append(temp);
    $('.jiarun_button').live('click',function(){
        $('#promotion_div input').css({'border':'solid 1px green'});
        buynow($('#jiarun_product_id').val(),$('#jiarun_product_option_id').val(),$('#jiarun_product_value_option_id').val());
    });
}

function cartDo(){
    window.location.href="/checkout/checkout";
}

function checkoutDo(){
    $('input[name=checkcode]').focus();
    $('input[name=checkcode]').keydown(function(e){
        var e = e || event,
            keycode = e.which || e.keyCode;
        if (keycode==13) {
            $('#submit_order').submit();
        }
    });
}

function buynow(product_id,product_option_id,product_option_value_id){

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data:"product_id="+product_id+"&option["+product_option_id+"]="+product_option_value_id,
        dataType: 'json',
        success: function(json) {
            $('.success, .warning, .attention, information, .error').remove();

            if (json['error']) {
                if (json['error']['option']) {
                    for (i in json['error']['option']) {
                        $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
                    }
                }
            }
            if (json['success']) {
                window.location.href="/checkout/checkout";
            }
        }
    });
}


if (navigator.userAgent.indexOf("Gecko") == -1) {
	alert("提醒：本脚本适合于 Firefox ，您当前的浏览器不兼容，请使用Firefox版本的脚本！");
} else {
	entryPoint();
}

//-----------------入口----------------------

//-----------------工具----------------------
function notify(str, timeout, skipAlert) {
	GM_notification(str);
}

function setCookie(name, value) {
	var Days = 30;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
	document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}

function getCookie(name) {
	var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
	if (arr != null) return unescape(arr[2]); return '';
}

//获得时间信息
function getTimeInfo() {
	var d = new Date();
	return d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
}
//-----------------工具----------------------


//-----------------自动刷新----------------------

//-----------------自动登录----------------------

function initLogin() {
	$("input.button[type=submit]").val("Test 按钮");
}

//-----------------自动登录----------------------
