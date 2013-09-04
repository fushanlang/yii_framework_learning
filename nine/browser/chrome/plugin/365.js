/*
 12306 Auto Submit => A javascript snippet to help you auto submit.
 Copyright (C) 2011 Kevintop
 Includes jQuery
 Copyright 2011, John Resig
 Dual licensed under the MIT or GPL Version 2 licenses.
 http://jquery.org/license

 Includes 12306.user.js
 https://gist.github.com/1554666
 Copyright (C) 2011 Jingqin Lynn
 Released GNU Licenses.

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program. If not, see <http://www.gnu.org/licenses/>.

 */

// ==UserScript==
// @name         12306 Auto Login
// @author       kevintop@gmail.com
// @namespace    https://plus.google.com/107416899831145722597
// @description  A javascript snippet to help you auto login 12306.com
// @include      *://www.365jiarun.com/account/login*
// ==/UserScript==
function withjQuery(callback, safe){
    if(typeof(jQuery) == "undefined") {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";

        if(safe) {
            var cb = document.createElement("script");
            cb.type = "text/javascript";
            cb.textContent = "jQuery.noConflict();(" + callback.toString() + ")(jQuery);";
            script.addEventListener('load', function() {
                document.head.appendChild(cb);
            });
        }
        else {
            var dollar = undefined;
            if(typeof($) != "undefined") dollar = $;
            script.addEventListener('load', function() {
                jQuery.noConflict();
                $ = dollar;
                callback(jQuery);
            });
        }
        document.head.appendChild(script);
    } else {
        callback(jQuery);
    }
}
withjQuery(function($){
//login

    //初始化
    if($("#refreshButton").size()<1){
        $("input.button[type=submit]").after($("<a href='#' style='padding: 5px 10px; background: #2CC03E;border-color: #259A33;border-right-color: #2CC03E;border-bottom-color:#2CC03E;color: white;border-radius: 5px;text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.2);'/>").attr("id", "refreshButton").html("自动登录").click(function() {
            alert('开始尝试登录，请点确定后耐心等待！');
            count = 1;
            $(this).html("(1)次登录中...");
            submitForm();
            return false;
        }));
        alert('如果使用自动登录功能，请输入用户名、密码及验证码后，点击自动登录，系统会尝试登录，直至成功！');
    }
}, true);
