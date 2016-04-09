/*!
 *
 * Welcome to view this js file. X_X
 * Name:Doit.im javascipt library
 * Site:http://www.doit.im/
 * Description:All javascript library used in doit.im
 *
 */
/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright 漏 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright 漏 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */

/**
 * @license In-Field Label jQuery Plugin
 * http://fuelyourcoding.com/scripts/infield.html
 *
 * Copyright (c) 2009-2010 Doug Neiner
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://docs.jquery.com/License
 *
 * @version 0.1.2
 */
(function ($) {

  $.InFieldLabels = function (label, field, options) {
    // To avoid scope issues, use 'base' instead of 'this'
    // to reference this class from internal events and functions.
    var base = this;

    // Access to jQuery and DOM versions of each element
    base.$label = $(label);
    base.label  = label;

    base.$field = $(field);
    base.field  = field;

    base.$label.data("InFieldLabels", base);
    base.showing = true;

    base.init = function () {
      // Merge supplied options with default options
      base.options = $.extend({}, $.InFieldLabels.defaultOptions, options);

      // Check if the field is already filled in
    //hack for chrome
    var checkFilled = setInterval(function(){
        if(!base.$label.is(':hidden')){
            if(base.$field.val() != ''){
                base.$label.hide();
                clearInterval(checkFilled);
            }
        }
    },1000);

    if (base.$field.val() !== "") {
        base.$label.hide();
        base.showing = false;
      }

      base.$field.focus(function () {
        base.fadeOnFocus();
      }).blur(function () {
        base.checkForEmpty(true);
      }).bind('keydown.infieldlabel', function (e) {
        // Use of a namespace (.infieldlabel) allows us to
        // unbind just this method later
        base.hideOnChange(e);
      }).bind('paste', function (e) {
        // Since you can not paste an empty string we can assume
        // that the fieldis not empty and the label can be cleared.
        base.setOpacity(0.0);
      }).change(function (e) {
        base.checkForEmpty();
      }).bind('onPropertyChange', function () {
        base.checkForEmpty();
      });
    };

    // If the label is currently showing
    // then fade it down to the amount
    // specified in the settings
    base.fadeOnFocus = function () {
      if (base.showing) {
        base.setOpacity(base.options.fadeOpacity);
      }
    };

    base.setOpacity = function (opacity) {
      base.$label.stop().animate({ opacity: opacity }, base.options.fadeDuration);
      base.showing = (opacity > 0.0);
    };

    // Checks for empty as a fail safe
    // set blur to true when passing from
    // the blur event
    base.checkForEmpty = function (blur) {
      if (base.$field.val() === "") {
        base.prepForShow();
        base.setOpacity(blur ? 1.0 : base.options.fadeOpacity);
      } else {
        base.setOpacity(0.0);
      }
    };

    base.prepForShow = function (e) {
      if (!base.showing) {
        // Prepare for a animate in...
        base.$label.css({opacity: 0.0}).show();

        // Reattach the keydown event
        base.$field.bind('keydown.infieldlabel', function (e) {
          base.hideOnChange(e);
        });
      }
    };

    base.hideOnChange = function (e) {
      if (
          (e.keyCode === 16) || // Skip Shift
          (e.keyCode === 9) // Skip Tab
        ) {
        return; 
      }

      if (base.showing) {
        base.$label.hide();
        base.showing = false;
      }

      // Remove keydown event to save on CPU processing
      base.$field.unbind('keydown.infieldlabel');
    };

    // Run the initialization method
    base.init();
  };

  $.InFieldLabels.defaultOptions = {
    fadeOpacity: 0.5, // Once a field has focus, how transparent should the label be
    fadeDuration: 300 // How long should it take to animate from 1.0 opacity to the fadeOpacity
  };


  $.fn.inFieldLabels = function (options) {
    return this.each(function () {
      // Find input or textarea based on for= attribute
      // The for attribute on the label must contain the ID
      // of the input or textarea element
      var for_attr = $(this).attr('for'), $field;
      if (!for_attr) {
        return; // Nothing to attach, since the for field wasn't used
      }

      // Find the referenced input or textarea element
      $field = $(
        "input#" + for_attr + "[type='text']," + 
        "input#" + for_attr + "[type='search']," + 
        "input#" + for_attr + "[type='tel']," + 
        "input#" + for_attr + "[type='url']," + 
        "input#" + for_attr + "[type='email']," + 
        "input#" + for_attr + "[type='password']," + 
        "textarea#" + for_attr
      );

      if ($field.length === 0) {
        return; // Again, nothing to attach
      } 

      // Only create object for input[text], input[password], or textarea
      (new $.InFieldLabels(this, $field[0], options));
    });
  };

}(jQuery));

String.prototype.format = function(){
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
        return typeof args[number] != 'undefined' ? args[number] : match;
    });
};

var Do = new Object();
(function() {
  var tmp = document.createElement("input");
  window.supports = {
    // 检测input是否支持placeholder特性
    placeholder: "placeholder" in tmp
  }
})();
// 绑定input的placeholder
Do.bindPlaceholder = function(input) {
  if(!window.supports.placeholder) {
    var jqInput = $(input),placeholder = jqInput.attr("placeholder");

    if(placeholder) {
          if(input.value == "") {
            input.value = placeholder;
            $(input).addClass("placeholder");
          }
          jqInput.focus(function() {
            if(this.value == placeholder) {
              $(this).removeClass("placeholder");
              this.value = "";
            }
          }).blur(function() {
            if(this.value == "") {
              $(this).addClass("placeholder");
              this.value = placeholder;
            }
          });
    }
  }
};

/* jQuery Cookies */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

/* Sing up */
$(document).ready(function(){
    //placeholder
    //var resetInput = setTimeout(function(){
        //$('#signin_form .form-input').each(function(){
            //if($(this).val() != ''){
                //$(this).parent().find('lable').hide();
            //}
        //});
    //},2000);
    //多语言切换
    $('header .lang').bind('click',function(){
            $('header .lang-dropmenu').toggle();
    });
    $('header .lang-dropmenu a').bind('click',function(){
        $('header .lang-dropmenu').hide();
        var lang = $(this).attr('data-lang');
        $('#langs_switch .lang i').removeClass().addClass(lang);
        switch(lang){
            case 'cn':
                $.cookie("PLAY_LANG", "zh_CN", {
                    path: '/',
                    expires: 365
                });
                break;
            case 'ja':
                $.cookie("PLAY_LANG", "ja", {
                    path: '/',
                    expires: 365
                });
                break;
            case 'tw':
                $.cookie("PLAY_LANG", "zh_TW", {
                    path: '/',
                    expires: 365
                });
                break;
            default:
                $.cookie("PLAY_LANG", "en", {
                    path: '/',
                    expires: 365
                });
                break;
        }
        window.location = window.location;
        return false;
    });

    //$("input[placeholder]").each(function() {
      ////Do.bindPlaceholder(this);
    //});


    //重发验证邮件
    $('#active_email_resend a').bind('click',function(){
        var $this = $(this);
        var $parent = $this.parent();
        $.get('/member/resend', function(data) {
            if($parent.find('span').length > 0){
                $parent.find('span').html(L.RESEND_SUCCESS);
            }else{
                $parent.append('<span style="padding:0 0 0 20px;color:#ff0000;display:none">' + L.RESEND_SUCCESS + '</span>');
            }
            $parent.find('span').fadeIn();
            setTimeout(function(){
                $parent.find('span').fadeOut();
            },2000);
        });
    });


    function setDefaultLanguage(){
        var PLAY_LANG = $.cookie('PLAY_LANG');

        //show default language when signin
        if(PLAY_LANG == "zh_CN"){
            $("#user_language_cn").attr("checked", true);
        }else if(PLAY_LANG == "zh_TW"){
            $("#user_language_tw").attr("checked", true);
        }else {
            $("#user_language_en").attr("checked", true);
        }

        //show selected language in .web-mate
        //if ( PLAY_LANG == 'cn' ) {
            //$('#language').text($('.language-dropdown-mid li:eq(1)').text());
        //} else if ( PLAY_LANG == 'tw' ) {
            //$('#language').text($('.language-dropdown-mid li:eq(2)').text());
        //} else {
            //$('#language').text($('.language-dropdown-mid li:eq(0)').text());
        //}
    }

    setDefaultLanguage();
    //$('#language').showLanguageDropDown();

    $('#user_account').isCheckAccount();
    $('#user_username').isCheckUserName();
    $('#user_username_re').isReCheckUserName();
    $('#user_nickname').isCheckNickName();
    $('#password').isCheckPassword();
    // $('.radiobutton input').isCheckLanguage();
    $('#agree-rules').isCheckAgreeRules();
    $('#signup-form').isSignup();
    $('#signup-form-oauth').isSignupOauth();

    $('#signin_form').bind('submit', function () {
        $('#username, #login_password').each(function (i, el) {
            var $p = $(el).parents('.input_box');
            if ($(el).val().length) {
                $p.find('.input_wrong').remove();
                $p.find('input').attr('class', 'form-input text_color_light f12');
            } else {
                $p.find('.input_wrong').remove();
                $p.find('input').attr('class', 'form-input form_input_wrong text_color_light f12');
                $p.append('<div class="input_wrong">wrong</div>');
                $(el).unbind('blur');
                $(el).bind('blur', function () {
                    if ($(el).val().length) {
                        $p.find('.input_wrong').remove();
                        $p.find('input').attr('class', 'form-input text_color_light f12');
                    }
                })
            }
        });
        if ($(this).find('div.input_wrong').length) {
            $(this).find('div.input_wrong').eq(0).parents('.input_box').find('input').focus();
            return false;
        }
        $(this).find('.submit_btn_box').addClass('submit-loading');
        return true;
    });
    $('#new-password').isCheckPassword();
    $('#confirm-new-password').isCheckConfirmPassword();
    $('#reset_password_form').resetPassword();
    
    function stringToBoolean(str){
        if(typeof str == 'boolean'){
            return str;
        }
        if(str == null){
            return false;
        }
        if(str == 'true'){
            return true;
        }else{
            return false;
        }
    };
    //验证添加用户名
    $('#add_username_form').bind('submit',function(){
        // $(this).data('olduser',true);
        var account = $('#account');
        account.data('active', true);
        if($.isEmptyObject(account.data('valid'))){
            account.triggerHandler('blur');
        }
        if(!stringToBoolean(account.data('valid'))){
            account.triggerHandler('focus');
            $('#add_username_form .input_box_hint').html('');
        }else{
            return true;
        }
        return false;
    });
    $('#account').isCheckAccount();


    //首页和downloads的分割线
    $('.doitim_downloads h3, .doitim_mobile h3').each(function (i, el) {
        var $el = $(el);
        $('<div style="width:100%;left:0;line-height:0; position:absolute; top:' + String($el.offset().top - 2) + 'px; border-top:#748795 1px solid; border-bottom:#36434b 1px solid;"></div>').appendTo('body');
    });
//    if ($.browser.webkit) {
//        //$('input[name="password"]').attr('autocomplete', 'off');
//    }
//    取消chrome自动填写的黄色背景
    //if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
        //$(window).load(function(){
            //$('input:-webkit-autofill').each(function(){
                //var text = $(this).val();
                //var name = $(this).attr('name');
                //$(this).after(this.outerHTML).remove();
                //$('input[name=' + name + ']').val(text);
            //});
        //});
    //}


    if ($('#release_note').length) {
        var lang = $.cookie('PLAY_LANG') == 'en' ? '' : '/'+$.cookie('PLAY_LANG');
        var platform_hash_title = {
            '#platform_web' : L.PLATFORM_WEB,
            '#platform_windows' : L.PLATFORM_WINDOWS,
            '#platform_iphone' : L.PLATFORM_IPHONE,
            '#platform_android' : L.PLATFORM_ANDROID
        };
        var show_note = function (platform_hash) {
            $('.release-side li').removeClass('s');
            $('.release-side li a[href=' + platform_hash + ']').parent().addClass('s');
            $('#release_note').load(lang+'/releases/'+platform_hash.substr(1)+' #release_wrap');
            location.hash = platform_hash;
        };
        //网页初次载入时
        var default_platform_hash;
        if (location.hash) {
            default_platform_hash = location.hash;
        }
        if (!default_platform_hash) default_platform_hash = '#web';
        show_note(default_platform_hash);

        //点击菜单
        $('.release-side a').click(function (ev) {
            var platform_hash = $(this).attr('href');
            location.hash = platform_hash;
            return false;
        });

        //浏览器后退前进
        var watchHash = (function () {
            var lastHash = location.hash;
            return function () {
                if (lastHash != location.hash) {
                    lastHash = location.hash;
                    show_note(lastHash);
                }
            }
        })();
        setInterval(watchHash, 100);
    }

    //if ($('.recruitment_wrap').length) {
        //var show_note = function (platform_hash) {
            //var $node = $(platform_hash).removeAttr('id');
            //$('.content_article_title').text(platform_hash_title[platform_hash]);
            //$node.show();
            //$('.release_notes_platform li').removeClass('current');
            //$('.release_notes_platform li a[href=' + platform_hash + ']').parent().addClass('current');
            //location.hash = platform_hash;
            //$node.attr('id', platform_hash.substr(1));
        //};
        ////网页初次载入时
        //$('.content_article:gt(0)').hide();

        ////点击菜单
        //$('.recruitment_tabs li a').click(function (ev) {
            //var $el = $(ev.currentTarget);
            //var hash = $el.attr('href').substr(1);
            //$('.content_article_title').text($el.text());
            //$('.content_article').hide();
            //$('#' + hash).show();
            //$('.recruitment_tabs li').removeClass('current');
            //$('.recruitment_tabs li a[href=#' + hash + ']').parent().addClass('current');
            //return false;
        //});
    //}
    //
    $(".holding label").inFieldLabels();
    $('.holding input[type="text"]:eq(0)').trigger('focus');

    /*---幻灯片展示---*/
    var slide = function(o){
        var _this = this;
        o.find('ol').each(function(){
            _this.num = 0;
            _this.self = $(this);
            _this.self.after('<div class="slide_num">');
            _this.nums = _this.self.next();
            _this.lis = _this.self.find('li');
            _this.lis.each(function(i){
                var span = $('<span>');
                span.html(i+1).attr('rel',i).click(function(){
                    clearInterval(_this.t);
                    var prevNum = parseInt($('.slide_num .hover').attr('rel'),10);
                    _this.run($(this).attr('rel'),prevNum,_this.timer());
                });
                span.appendTo(_this.nums);
            });
            _this.nums.find('span').eq(0).addClass('hover');
        });
        this.timer();
    };
    slide.init = function(){
        $('div.slide').each(function(){
            return new slide($(this));
        })
    };
    slide.prototype = {
        run:function(i,prev,callback){
            var _this_ = this;
            this.nums.find('span').eq(this.num).removeClass('hover');
            this.nums.find('span').eq(i).addClass('hover');
            this.num = i;
            this.lis.eq(0).stop();
            _this_.lis.eq(prev).find('.cap').animate({
                top:'300px'},100,'easeInOutExpo'
            );
            this.lis.eq(0).animate({
                marginTop:'-'+this.lis.eq(0).height()*this.num+'px'},600,'easeInOutExpo',function(){
                    _this_.lis.eq(i).find('.cap').animate({
                        top:'264px'},100,'easeInOutExpo'
                    );
                }
            );
            if(callback != null) callback();
        },
        timer:function(){
            var _this = this;
            this.t =  setInterval(function(){
                if(_this.num == _this.lis.size()-1){
                    _this.i = 0;
                }else{
                    _this.i = _this.num-1+2;
                }
                var prevNum = _this.i - 1 == -1 ? 4 : _this.i - 1;
                _this.run(_this.i,prevNum);
            },5000)
        }
    };
    $(slide.init);

    $('#reason .allow').bind('click',function(){
        //$('#main .intro,#main .signup').fadeOut(1000);
        $("html,body").animate({scrollTop: $("#reason").offset().top-20}, 1000,'easeInOutExpo');
    });
});

(function($){

    var password_minlength = 6;

    function addErrorMessage(target, message){
        target.data('valid', false);
        if (target.is('#agree-rules')) {
            target.parent().attr('class', 'text_color_red');
            return;
        }
        $box = target.parents('.input_box');
        $box.find('.input_box_tip').html(message);
        //$box.find('label').attr('class','text_color_red form_label f14');
        target.attr('class','form-input form_input_wrong text_color_light f12');
        $box.find('.input_wrong, .input_right').remove();
        $box.append('<div class="input_wrong">wrong</div>');
    };
    function addSuccessMessage(target){
        target.data('valid', true);
        if (target.is('#agree-rules')) {
            target.parent().attr('class', 'text_color_deep');
            return;
        }
        $box = target.parents('.input_box');
        $box.find('.input_box_tip').html('');
        //$box.find('label').attr('class','text_color_deep form_label f14');
        $box.find('input').attr('class','form-input form_input_right text_color_light f12');
        $box.find('.input_wrong, .input_right').remove();
        $box.append('<div class="input_right fl">right</div>');
    };

    function stringToBoolean(str){
        if(typeof str == 'boolean'){
            return str;
        }
        if(str == null){
            return false;
        }
        if(str == 'true'){
            return true;
        }else{
            return false;
        }
    };

    //$.fn.showLanguageDropDown = function () {
        //$('#language').one('click', function () {
            //var A = $(this);
            //var select_box = $('#language-dropdown');
            //A.parent().append(select_box.html()).find('ul li').each(function () {
                //var B = $(this);
                //B.click(function () {
                    //$('#language').text(B.text()).attr('value', B.children('input:hidden').attr('value'));
                    //$.cookie("PLAY_LANG", $('#language').attr('value'), {
                        //path: '/',
                        //expires: 5*356
                    //});
                    //window.location.reload(true);
                //});
            //});
            ////click anywhere should close drop down box
            //$('html').one('click', function () {
                //A.parent().find('.language-dropdown').remove().end().showLanguageDropDown();
                //return false;
            //});
            //return false;
        //});
    //};

    $.fn.isCheckNickName = function () {
        var A = $(this);
        A.bind('blur', function () {
            $(this).val($.trim($(this).val()));
            var active = stringToBoolean(A.data('active'));
            if (A.attr('value') != '' && !active) {
                A.data('active', true);
                active = true;
            }
            if (active) {
                var reg = /^[\u0391-\uFFE5\w.]+$/;
                //contains invalid char
                if(A.attr('value') == ''){
                    addErrorMessage(A, L.E_NICKNAME_REQUIRED);
                } else if (!reg.test(A.attr('value')) ){
                    addErrorMessage(A, L.E_NICKNAME_INVALID);
                } else {
                    addSuccessMessage(A);
                }
            }
        });
    };

    $.fn.isCheckUserName = function () {
        var A = $(this);
        A.bind('blur', function(){
            $(this).val($.trim($(this).val()));
            var active = stringToBoolean(A.data('active'));
            if(A.attr('value') != '' && !active){
                A.data('active', true);
                active = true;
            }
            if(active){
                if(A.attr('value') == ''){
                    addErrorMessage(A, L.E_USERNAME_REQUIRED);
                }else if(!$.isEmail(A.attr('value'))){
                    addErrorMessage(A, L.E_USERNAME_INVALID);
                }else{
                    //ajax check username
                    ajaxCheckMember('username', $.trim(A.val()), A);
                }
            }
        });
    };
    $.fn.isReCheckUserName = function () {
        var A = $(this);
        A.bind('blur', function(){
            $(this).val($.trim($(this).val()));
            var active = stringToBoolean(A.data('active'));
            if(A.attr('value') != '' && !active){
                A.data('active', true);
                active = true;
            }
            if(active){
                if(A.attr('value') == ''){
                    addErrorMessage(A, L.E_USERNAME_REQUIRED);
                }else if(!$.isEmail(A.attr('value'))){
                    addErrorMessage(A, L.E_USERNAME_INVALID);
                }else if($.trim($(this).val()) != $.trim($('#user_username').val())){
                    addErrorMessage(A, L.E_USERNAME_RE);
                }else{
                    //ajax check username
                    ajaxCheckMember('username', $.trim(A.val()), A);
                }
            }
        });
    };
    $.checkEmail = function(obj){
        var A = $(obj);
        A.val($.trim(A.val()));
        var active = stringToBoolean(A.data('active'));
        if(A.attr('value') != '' && !active){
            A.data('active', true);
            active = true;
        }
        if(active){
            if(A.attr('value') == ''){
                addErrorMessage(A, L.E_USERNAME_REQUIRED);
            }else if(!$.isEmail(A.attr('value'))){
                addErrorMessage(A, L.E_USERNAME_INVALID);
            }else if($.trim(A.val()) != $.trim($('#user_username').val())){
                addErrorMessage(A, L.E_USERNAME_RE);
            }else{
                //ajax check username
                ajaxCheckMember('username', $.trim(A.val()), A);
            }
        }
    };
    $.fn.isCheckAccount = function () {
        var A = $(this);
        A.bind('focus', function () {
            A.parents('.input_box').find('.input_box_hint').html(L.E_USERNAME_TIP);
            A.parents('.input_box').find('.input_box_tip').html('');
        });
        A.bind('blur', function(){
            $(this).val($.trim($(this).val()));
            A.parents('.input_box').find('.input_box_hint').html('');
            var active = stringToBoolean(A.data('active'));
            if(A.attr('value') != '' && !active){
                A.data('active', true);
                active = true;
            }
            if(active){
                if(A.attr('value') == ''){
                    addErrorMessage(A, L.E_ACCOUNT_REQUIRED);
                }else if(!$.isAccount(A.attr('value'))){
                    addErrorMessage(A, L.E_USERNAME_TIP);
                }else{
                    //ajax check username
                    ajaxCheckMember('account', $.trim(A.val()), A);
                }
            }
        });
    };
    $.isAccount = function(value) {
        return /^[0-9a-zA-Z_]+$/.test(value);
    };
    function setSettingButton(button, status){
        if(status == 'disabled'){
            button.addClass('disabled');
        }else{
            button.removeClass('disabled');
        }
    }
    function ajaxCheckMember(_u, p, A) {
        var ua = (_u && _u == 'account') ? 'account' : 'username';
        var d = {};
        d[ua] = p;
        $.getJSON("/member/check_" + ua + '?callback=?', d, function(data, textStatus, xhr){
                if (data) {
                    addSuccessMessage(A);
                } else {
                    // if($('#add_username_form').data('olduser') == true){
                    //     addErrorMessage(A, L['E_'+_u.toUpperCase()+'_EXIST']);
                    // }else{
                        addErrorMessage(A, L['E_'+_u.toUpperCase()+'_EXIST'].format(p));
                    // }
                }
            });
    }

    $.fn.isCheckPassword = function () {
        var A = $(this);
        A.bind('focus', function () {
            A.parents('.input_box').find('.input_box_hint').html(L.E_PASSWORD_TIP);
            A.parents('.input_box').find('.input_box_tip').html('');
        });
        A.bind('blur', function(){
            A.parents('.input_box').find('.input_box_hint').html('');
            var value = A.attr('value');
            var active = stringToBoolean(A.data('active'));
            if(value != '' && !active){
                A.data('active', true);
                active = true;
            }
            if(active){
                if(value == ''){
                    addErrorMessage(A, L.E_PASSWORD_REQUIRED);
                }else if(value.length < password_minlength){
                    addErrorMessage(A, L.E_PASSWORD_TIP);
                }else{
                    addSuccessMessage(A);
                }
            }
            $('#confirm-new-password').trigger('blur');
        });
    };

    $.fn.isCheckConfirmPassword = function () {
        var A = $(this);
        A.bind('blur', function(){
            var value = A.attr('value');
            var active = stringToBoolean(A.data('active'));
            if(value != '' && !active){
                A.data('active', true);
                active = true;
            }
            if(active){
                if(value == ''){
                    addErrorMessage(A, L.E_PASSWORD_REQUIRED);
                }else if(value != $('#new-password').val()){
                    addErrorMessage(A, L.E_PASSWORD_CONSISTENT);
                }else{
                    addSuccessMessage(A);
                }
            }
        });
    };

    // $.fn.isCheckLanguage = function () {
    //     var A = $(this);
    //     //if language default is checked, then language_valid is true
    //     if(A.attr('checked')){
    //         language_valid = true;
    //     }
    //     A.bind('click', function(){
    //         if($('.radiobutton input:checked').length == 1){
    //             addSuccessMessage(A);
    //         }else{
    //             addErrorMessage(A, "");
    //         }
    //     });
    // };

    $.fn.isCheckAgreeRules = function () {
        var A = $(this);
        A.bind('click', function(){
            if($('#agree-rules:checked').length == 1){
                addSuccessMessage(A);
            }else{
                addErrorMessage(A, "");
            }
        });
    };

    $.fn.isSignup = function () {
        var A = $(this);
        A.bind('submit', function(){
            var account = $('#user_account');
            var username = $('#user_username');
            var username_re = $('#user_username_re');
            var nickname = $('#user_nickname');
            var password = $('#password');
            // var language = $('.radiobutton input');
            var agree_rules = $('#agree-rules');

            account.data('active', true);
            username.data('active', true);
            username_re.data('active', true);
            nickname.data('active', true);
            password.data('active', true);

            //if never focusin, then trigger event for check
            if($.isEmptyObject(account.data('valid'))){
                account.triggerHandler('blur');
            }
            if($.isEmptyObject(username.data('valid'))){
                username.triggerHandler('blur');
            }
            if($.isEmptyObject(username_re.data('valid'))){
                username_re.triggerHandler('blur');
            }
            if($.isEmptyObject(password.data('valid'))){
                password.triggerHandler('blur');
            }
            // if($.isEmptyObject(language.data('valid'))){
            //     language.triggerHandler('click');
            // }
            if($.isEmptyObject(agree_rules.data('valid'))){
                agree_rules.triggerHandler('click');
            }
            //focus the first invalid place
            if(!stringToBoolean(account.data('valid'))){
                account.focus();
            }else if(!stringToBoolean(username.data('valid'))){
                username.focus();
            }else if(!stringToBoolean(username_re.data('valid'))){
                username_re.focus();
            }else if(!stringToBoolean(password.data('valid'))){
                password.focus();
            /*}else if(!stringToBoolean(language.data('valid'))){
                $('.radiobutton input:first').focus();*/
            }else if(!stringToBoolean(agree_rules.data('valid'))){
                $('#agree-rules').focus();
            }else{
                //$('#user_timezone').attr('value', -(new Date()).getTimezoneOffset() / 60);
                $(this).find('.submit_btn_box').addClass('submit-loading');
                return true;
            }
            return false;
        });
    };

    $.fn.isSignupOauth = function () {
        var A = $(this);
        A.bind('submit', function(){
            var account = $('#user_account');
            var password = $('#password');
            // var language = $('.radiobutton input');
            var agree_rules = $('#agree-rules');

            account.data('active', true);
            password.data('active', true);

            //if never focusin, then trigger event for check
            if($.isEmptyObject(account.data('valid'))){
                account.triggerHandler('blur');
            }
            if($.isEmptyObject(password.data('valid'))){
                password.triggerHandler('blur');
            }
            // if($.isEmptyObject(language.data('valid'))){
            //     language.triggerHandler('click');
            // }
            if($.isEmptyObject(agree_rules.data('valid'))){
                agree_rules.triggerHandler('click');
            }
            //focus the first invalid place
            if(!stringToBoolean(account.data('valid'))){
                account.focus();
            }else if(!stringToBoolean(password.data('valid'))){
                password.focus();
            /*}else if(!stringToBoolean(language.data('valid'))){
                $('.radiobutton input:first').focus();*/
            }else if(!stringToBoolean(agree_rules.data('valid'))){
                $('#agree-rules').focus();
            }else{
                //$('#user_timezone').attr('value', -(new Date()).getTimezoneOffset() / 60);
                return true;
            }
            return false;
        });
    };

    $.signup = function(){
        var account = $('#user_account');
        var username = $('#user_username');
        var username_re = $('#user_username_re');
        var nickname = $('#user_nickname');
        var password = $('#password');
        // var language = $('.radiobutton input');
        var agree_rules = $('#agree-rules');

        account.data('active', true);
        username.data('active', true);
        username_re.data('active', true);
        nickname.data('active', true);
        password.data('active', true);

        //if never focusin, then trigger event for check
        if(account.attr('valid') == null){
            account.triggerHandler('blur');
        }
        if(username.attr('valid') == null){
            username.triggerHandler('blur');
        }
        if(username_re.attr('valid') == null){
            username_re.triggerHandler('blur');
        }
        if(password.attr('valid') == null){
            password.triggerHandler('blur');
        }
        // if(language.attr('valid') == null){
        //     language.triggerHandler('click');
        // }
        if(agree_rules.attr('valid') == null){
            agree_rules.triggerHandler('click');
        }
        //focus the first invalid place
        if(account.attr('valid') == 'false'){
            account.focus();
        }else if(username.attr('valid') == 'false'){
            username.focus();
        }else if(username_re.attr('valid') == 'false'){
            username_re.focus();
        }else if(password.attr('valid') == 'false'){
            password.focus();
        /*}else if(!stringToBoolean(language.data('valid'))){
            $('.radiobutton input:first').focus();*/
        }else if(agree_rules.attr('valid') == 'false'){
            $('#agree-rules').focus();
        }else{
            //$('#user_timezone').attr('value', -(new Date()).getTimezoneOffset() / 60);
            return true;
        }
        return false;
    };

    $.fn.resetPassword = function () {
        $(this).bind('submit', function(){
        var $np = $('#new-password');
        var $cnp = $('#confirm-new-password');

        $np.data('active', true);
        $cnp.data('active', true);

        //if never focusin, then trigger event for check
        if($.isEmptyObject($np.data('valid'))){
            $np.triggerHandler('blur');
        }
        if($.isEmptyObject($cnp.data('valid'))){
            $cnp.triggerHandler('blur');
        }
        //focus the first invalid place
        if(!stringToBoolean($np.data('valid'))){
            $np.focus();
        }else if(!stringToBoolean($cnp.data('valid'))){
            $cnp.focus();
        }else{
            return true;
        }
        return false;
    });

    };


})(jQuery);

/* Common */
(function($){
    //Sweet title by leeiio
    Do.sweetTitles = function(obj){
        var x = 10;
        var y = 20;
        if(obj == null){
            var tipElements = "a[title],div[title],span[title],li[title]";
        }else{
            var tipElements = obj;
        }
        $(tipElements).mouseover(function(e){
            this.myTitle = this.title;
            this.title = "";
            if($('#tooltip').is('div')){}else{
                var tooltip = "<div id='tooltip'>"+this.myTitle+"</div>";
            }
            $('body').append(tooltip);
            $('#tooltip').css({
                "opacity":"1",
                "top":(e.pageY+y)+"px",
                "left":(e.pageX+x)+"px"
            }).show('fast');
        }).mouseout(function(){
            this.title = this.myTitle;
            $('#tooltip').remove();
        }).mousemove(function(e){
            $('#tooltip').css({
                "top":(e.pageY+y)+"px",
                "left":(e.pageX+x)+"px"
            });
        });
    };

    $.fn.isSweetTitles = function(){
        var x = 10;
        var y = 20;
        var A = this;
        A.one('mouseover',function(e){
            this.myTitle = this.title;
            this.title = "";
            if($('#tooltip').is('div')){}else{
                var tooltip = "<div id='tooltip'>"+this.myTitle+"</div>";
            }
            $('body').append(tooltip);
            $('#tooltip').css({
                "opacity":"1",
                "top":(e.pageY+y)+"px",
                "left":(e.pageX+x)+"px"
            }).show('fast');
        }).one('mouseout',function(e){
            this.title = this.myTitle;
            $(this).isSweetTitles();
            $('#tooltip').remove();
        }).mousemove(function(e){
            $('#tooltip').css({
                "top":(e.pageY+y)+"px",
                "left":(e.pageX+x)+"px"
            });
        });
    };

    //Text-Overflow Ellipsis
    // $.fn.ellipsis = function(enableUpdating){
    //     var s = document.documentElement.style;
    //     if (!('textOverflow' in s || 'OTextOverflow' in s)) {
    //         return this.each(function(){
    //             var el = $(this);
    //             if(el.css("overflow") == "hidden"){
    //                 var originalText = el.html();
    //                 var w = el.width();

    //                 var t = $(this.cloneNode(true)).hide().css({
    //                     'position': 'absolute',
    //                     'width': 'auto',
    //                     'overflow': 'visible',
    //                     'max-width': 'inherit'
    //                 });
    //                 el.after(t);
    //                 var text = originalText;
    //                 while(text.length > 0 && t.width() > el.width()){
    //                     text = text.substr(0, text.length - 1);
    //                     t.html(text + "...");
    //                 }
    //                 el.html(t.html());

    //                 t.remove();

    //                 if(enableUpdating == true){
    //                     var oldW = el.width();
    //                     setInterval(function(){
    //                         if(el.width() != oldW){
    //                             oldW = el.width();
    //                             el.html(originalText);
    //                             el.ellipsis();
    //                         }
    //                     }, 200);
    //                 }
    //             }
    //         });
    //     } else return this;
    // };

    $.isEmail = function(value){
        return /^([-a-z0-9!\#$%&'*+\/=?^_`{|}~]+\.)*[-a-z0-9!\#$%&'*+\/=?^_`{|}~]+@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i.test(value);
    };
})(jQuery);

