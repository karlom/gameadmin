<?php /* Smarty version 2.6.25, created on 2014-04-30 15:39:30
         compiled from login.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
                                                                                                       
                                                      
            
          DESIGN01      BY00000      YDB00     00    00      000000       000  000      
           000          000           000      00    10     000  000      000  000    
           000          000           000       00  00      000  000      000  000 
           0000000      0000010       000         00        000  000      000  000  
           000          000           000         00        000  000      000  000
           000          100           000         00        000  000      000  000
          F0001         U000001      C0001       K0001       GF0001        W00001                                                                                 
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/static/css/login.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.js"></script>
<script type="text/javascript" src="/static/js/web.js"></script>
<script type="text/javascript" src="/static/js/cn.js"></script>
<title><?php echo $this->_tpl_vars['GAME_ZH_NAME']; ?>
后台登陆</title>

</head>
<body id="home" class="windows">
<header>
    <div class="inner">
        <div class="logo">
        		
        </div>
        <nav>
            <ul>
                <li"><?php echo $this->_tpl_vars['GAME_ZH_NAME']; ?>
后台登陆</li>
            </ul>
        </nav>
        <div class="member">
        @xlfb版权所有
        </div>
    </div>
</header>


<div id="main_wrap">
    <div id="main">
        <div class="inner form">
            <div class="signin-box form-box">
              <form method="post" action="" class="holding" id="signin_form">
              	<input type="hidden" name="action" value="login"/>
                  <div class="input_box clearfix">
                                        <p class="input_wrap">
                      <label for="username">用户名</label><br />
                      <input id="username"  type="text" name="username" class="form-input text_color_light f12" />
                    </p>
                  </div>

                  <div class="input_box clearfix">
                    <p class="input_wrap">
                      <label for="login_password">密码</label><br />
                      <input id="login_password" type="password" name="password" class="form-input text_color_light f12"/>
                    </p>
                  </div>
                  <?php if ($this->_tpl_vars['CHECK_CODE_SWITCH']): ?>
                <div class="input_box clearfix">
                                        <p class="input_wrap">
                      <label for="checkcode">验证码</label><br />
                      <input id="checkcode"  type="text" name="checkcode" class="form-input text_color_light f12" />
                    </p>
                  </div>
                  <div>
                   <img src="./checkcode.php" id="checkcode" onclick="this.src='./checkcode.php?id='+Math.random()*5;" style="cursor:pointer;" alt="验证码,看不清楚?请点击刷新验证码" align="absmiddle"/>
                  </div>
                  <?php endif; ?>
                  <br/><br/>

                  <div class="submit_btn_box" style="align:center;">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nbsp> <input type="submit" class="middle_btn submit_btn text_color_deep_btn" style="cursor:pointer;" value="登录"/>
                </div>
               
                </form>
                <hr/>
                <?php if ($this->_tpl_vars['errorMsg']): ?>
                <?php echo $this->_tpl_vars['errorMsg']; ?>

                <?php endif; ?>
              </div>
        </div>
    </div>
</div>
</body>
</html>