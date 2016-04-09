var L=new Object();L.CREATE="创建";L.TAG="标签";L.INBOX="收集箱";L.TODAY="今日待办";L.DOITNOW="立即处理";L.WAITING_FOR="等待";L.WAITING="等待";L.TOMORROW="明日待办";L.NEXT="下一步行动";L.SCHEDULED="日程";L.SOMEDAY="择日待办";L.COMPLETED="已完成";L.ARCHIVER="归档库";L.TRASH="垃圾箱";L.ME="我";L.POST="发表";L.TIMEAGO_LESS_THAN_ONE="小于1分钟";L.TIMEAGO_ONE_MIN_GO="1分钟前";L.TIMEAGO_X_MINS_GO="{0}分钟前";L.TIMEAGO_ONE_HOUR_GO="1小时前";L.TIMEAGO_X_HOURS_GO="{0}小时前";L.PLACEHOLDER_COMMENT="在此输入您的评论...";L.TASKFORM_TAG="标签";L.TASKFORM_CONTEXT="情境";L.TASKFORM_PROJECT="项目";L.TASKFORM_ADD_EXIST="请不要重复添加";L.TASKFORM_PLS_SET_START_TIME_FIRST="请先设置开始时间";L.TASKFORM_REMINDER_ONDATE="具体时间";L.MINS="分钟";L.HOURS="小时";L.DAYS="天";L.MIN="分钟";L.HOUR="小时";L.DAY="天";L.TASKFORM_NO_CONTACTS="无联系人";L.DATEPICKER_TIME="时间设定：";L.TASK_PRI0="无";L.TASK_PRI1="低";L.TASK_PRI2="中";L.TASK_PRI3="高";L.TASKFORM_SEND="发送";L.TASKFORM_TASK_SEND_OK="任务已发送。";L.REMINDER_EMAIL="邮件";L.REMINDER_POPUP="弹出框";L.REMINDER_STR="提前 {0} {1} ({2});";L.EMAIL=" 使用邮件提醒";L.POPUP=" 使用弹出框提醒";L.REMINDER_ALREADY_SENT="已经 {0} 过";L.TAG_NONE="未加标签";L.TAG_ALL="全部";L.TIPS_TASK_ADDED_OK="任务添加成功";L.GROUPBY_TODAY_OTHERS="今日其他";L.GROUPBY_ARCHIVED="已归档";L.GROUPBY_NONE="未分组";L.GROUPBY_DEFAULT="按默认";L.GROUPBY_BEFORE_TODAY="今天之前";L.i_group_forward_received="接收到的任务";L.i_group_forward_send="已发出的任务";L.i_group_schedule_nextweek="下周";L.i_group_schedule_thisweek="本周";L.i_group_schedule_tomorrow="明天";L.i_group_schedule_today="今天";L.i_group_schedule_sent="转发给他人的任务";L.i_group_schedule_senttomulti="发送给多人";L.i_group_schedule_senttoone="发送给{0}";L.i_group_schedule_mine="我的任务";L.i_rest_of_this_month="本月其他";L.i_next_month="下月及以后";L.i_no_start_on="无开始时间";L.i_no_end_at="无截止时间";L.ACTIVE_GROUP="已激活项目";L.INACTIVE_GROUP="已冻结项目";L.COMPLETED_GROUP="已完成项目";L.DELETED_GROUP="已删除项目";L.NO_PRIORITY="未设优先级";L.GROUP_BY_SCHEDULE="按开始时间";L.GROUP_BY_DEADLINE="按截止时间";L.GROUP_BY_CONTEXT="按情境";L.GROUP_BY_PROJECT="按项目";L.GROUP_BY_TIME="按时间";L.GROUP_BY_PRIORITY="按优先级";L.PROJECT_EDIT="编辑项目";L.EMPTY_NOTASKS="当前箱子没有未完成任务！";L.i_empty_tip_inbox="将脑中一切待办任务扔进收集箱，以待逐条细化。";L.i_empty_tip_today="您每次进入系统首先看到今日待办箱，当天开始或截止的任务都会显示于此。";L.i_empty_tip_today_2="当您完成所有今日待办任务后，您将会看到“下一步行动”按钮。点击此按钮，便能根据需要选择您接下来要处理的事务。";L.i_empty_tip_next="没有确切开始时间但需要尽快完成的任务都存放在下一步行动箱中。";L.i_empty_tip_tomorrow="待明日处理的任务显示在明日待办箱中，午夜之后将自动进入今日待办。";L.i_empty_tip_scheduled="所有开始时间为后天及以后的待办任务（包括重复任务）均在日程箱中。";L.i_empty_tip_scheduled_2="当您将任务拖拽到此箱时，请在弹出的时间选择器上选择执行时间。";L.i_empty_tip_someday="尚不确定开始时间、也许将来要做的事宜，可放入此箱。";L.i_empty_tip_waiting="所有已转发出去的任务会自动显示于等待箱子；当然，您也可以将自己的任务拖进此箱。";L.i_empty_tip_completed="勾选任务前的勾选框便能完成任务；而点“归档”按钮后，任务便进入归档库页面。";L.i_empty_tip_completed_2="若点击了本箱上的“归档”按钮，相应任务便直接进入归档页面。";L.i_empty_tip_trash="打开任务点”删除”按钮，或拖拽到垃圾箱，该任务便被删除。点击“清空”便能清空垃圾箱。";L.i_empty_tip_no_context="未设情境的待办任务均在此箱中。";L.i_empty_tip_all_context="本箱中可看到所有设有情境的待办任务。";L.i_empty_tip_ptc_context="本箱中看到的是该情境下的任务。";L.i_empty_tip_context="本箱中可看到该情境下的所有任务";L.i_empty_tip_no_project="未设项目的待办任务均在此箱中。";L.i_empty_tip_all_project="本箱中可看到所有设有项目的待办任务。";L.i_empty_tip_ptc_project="本箱中看到的是归属该项目下的任务。";L.i_empty_tip_all_project_2="当然，项目还可被当作多步骤任务使用。";L.i_empty_tip_project="本箱中可看到归属该项目的所有任务。";L.i_empty_tip_group="本箱显示：您转发给该组成员的任务，该组成员转发给您的任务，以及该组成员已完成的任务。";L.i_empty_tip_all_group="本箱内容包括：所有您转发出去的任务(包括未完成和已完成)，所有转发给您且未完成的任务。（您自己完成的任务都会进入时间模式下的“已完成”箱子）";L.i_empty_tip_all_group_2="您可以给好友转发任务，不过在您添加其为Doit.im联系人且对方已同意前，您的转发任务将会进入到对方邮箱。";L.i_empty_tip_contact="在转发任务前，请先确保对方已通过您的联系人申请。";L.i_empty_tip_archiver_week="可在此查看任一周（可选）的归档任务。";L.i_empty_tip_archiver_month="可在此查看任一月（可选）的归档任务。";L.i_empty_tip_review="您可在此看到今日或本周所有待办和已完成的任务，以便对其进行调整或重新安排。";L.i_empty_tip_contact_all="在转发任务前，请先确保对方已通过您的联系人申请。";L.i_empty_tip_contact_group="本箱包含您与该组成员相互转发的待办任务。";L.i_empty_tip_contact_person="本箱包含您与该联系人相互转发的待办任务。";L.i_empty_tip_doitnow="太棒了，“立即处理”的任务都已完成！";L.OK="确定";L.EDIT="编辑";L.SAVE="保存";L.BACK="返回";L.DELETE="删除";L.CANCEL="取消";L.CLOSE="关闭";L.RESEND="重新发送";L.WORDSPACE="";L.COMMA="，";L.PROJECT="项目";L.CONTEXT="情境";L.EG="例如：";L.AJAX_PROJECT_ADDING_FAILED="项目创建失败。";L.AJAX_CONTEXT_ADDING_FAILED="情境创建失败。";L.AJAX_TASK_ADDING_FAILED="任务创建失败。";L.EDIT_TASK="编辑任务";L.TIME="时间:";L.REPEAT="重复";L.NO_CONTEXT="未指定";L.NEW_CONTEXT="新情境";L.ADD_NEW_CONTEXT="新增情境";L.ADD_NEW_CONTACT="新增联系人";L.ADD_NEW_CONTACT_GROUP="新增联系人群组";L.EDIT_CONTACT_GROUP="编辑联系人群组";L.NEW_CONTACT="新联系人";L.NEW_CONTACT_GROUP="新联系人群组";L.NO_PROJECT="未指定";L.NEW_PROJECT="新项目";L.COMPLETE_PROJECT="完成该项目";L.NO_TAG="未指定";L.TF_REMINDER="提醒";L.TF_PRIORITY="优先级";L.TASK_START_AT="设置开始时间";L.TASK_END_AT="设置截止时间";L.PROJECTFORM_ADDINPUT="请输入项目名称";L.taskbar_priority="优先级";L.taskbar_reminder="提醒";L.taskbar_today="今日待办";L.taskbar_now="立即处理";L.taskbar_repeat="重复任务";L.taskbar_forward="来自 ";L.taskbar_forward_to="发给 ";L.NONE="不重复";L.END_TIME="结束时间";L.RR_COMMA="，";L.RR_CAESURA="、";L.RR_SUN="周日";L.RR_MON="周一";L.RR_TUS="周二";L.RR_WED="周三";L.RR_THU="周四";L.RR_FRI="周五";L.RR_SAT="周六";L.RR_FIRST="一";L.RR_SECOND="二";L.RR_THIRD="三";L.RR_FOURTH="四";L.RR_FIFTH="五";L.RR_JAN="1月";L.RR_FEB="2月";L.RR_MAR="3月";L.RR_APR="4月";L.RR_MAY="5月";L.RR_JUN="6月";L.RR_JUL="7月";L.RR_JAG="8月";L.RR_SEP="9月";L.RR_OCT="10月";L.RR_NOV="11月";L.RR_DEC="12月";L.REPEAT_DAILY="每天重复";L.REPEAT_EVERY_X_DAYS="每{0}天重复";L.REPEAT_MONTHLY="每月重复";L.REPEAT_EVERY_X_MONTHS="每{0}月";L.REPEAT_MONTHLY_LAST_0="每月最后一天重复";L.REPEAT_EVERY_X_MONTHS_LAST_0="每{0}月最后一天重复";L.REPEAT_MONTHLY_LAST_1="每月倒数第二天重复";L.REPEAT_EVERY_X_MONTHS_LAST_1="每{0}月倒数第二天重复";L.REPEAT_MONTHLY_LAST_2="每月倒数第三天重复";L.REPEAT_EVERY_X_MONTHS_LAST_2="每{0}月倒数第三天重复";L.REPEAT_MONTHLY_ON_DAY="每月{0}号重复";L.REPEAT_EVERY_X_MONTH_ON_DAY="每{0}月{1}号重复";L.REPEAT_MONTHLY_LAST_WEEKDAY="每月最后一个{0}重复";L.REPEAT_EVERY_X_MONTHS_LAST_WEEKDAY="每{0}月最后一个{1}重复";L.REPEAT_MONTHLY_THE_WEEKDAY="每月第{0}个{1}重复";L.REPEAT_EVERY_X_MONTHS_THE_WEEKDAY="每{0}月第{1}个{2}重复";L.REPEAT_EVERY_X_WEEKS_ALLDAYS="每{0}周重复一整周";L.REPEAT_WEEKLY_ON="每周{0}重复";L.REPEAT_EVERY_X_WEEKS_ON="每{0}周{1}重复";L.REPEAT_WEEKDAY="每周工作日";L.REPEAT_WEEKDAY_X="每{0}周工作日";L.REPEAT_YEARLY="每年{0}{1}日重复";L.REPEAT_EVERY_X_YEARS="每{0}年{1}{2}日重复";L.REPEAT_ENDS_ON="，直到{0}";L.DIALOG_TITLE_WARNING="警告";L.DIALOG_WARNING_DELETE_PROJECT_HAS_TASKS="本项目中仍有未完成任务。";L.DIALOG_WARNING_DELETE_PROJECT="该操作将删除本项目中所有的任务，确认删除？";L.DIALOG_WARNING_DELETE_CONTEXT="该操作将移除相应任务中的此情境，确定删除？";L.DIALOG_WARNING_COMPLETE_PROJECT="本项目中仍有未完成任务。你想如何处理？";L.DIALOG_WARNING_COMPLETE_PROJECT_DELETE="标为删除";L.DIALOG_WARNING_COMPLETE_PROJECT_COMPLETE="标为完成";L.DIALOG_WARNING_ARCHIVE="确定归档“已完成”箱子中的任务？归档后这些任务都将进入“归档库”。";L.DIALOG_WARNING_EMPTY_TRASH="确定永久清空“垃圾箱”中所有任务？";L.DIALOG_WARNING_OPERATION_IRRECOVERABLE="（此操作不可逆）";L.DIALOG_WARNING_COMMENTS_TO_NOTES_LIMIT="转化成项目后，由于备注字数限制，将会丢失您评论的部分信息。";L.CONTEXT_TIP="请输入一个新情境名";L.CONTEXT_EXIST="情境已存在。";L.CONTEXT_EDIT="编辑情境";L.PROJECT_TIP="请输入一个新项目名";L.PROJECT_EXIST="已存在同名项目，请修改项目名。";L.PROJECT_EXIST_NEED_ACTION="已存在同名已完成项目，是否打开已有项目？";L.PROJECT_EXIST_NEED_ACTION_OPEN="打开已有";L.PROJECT_EXIST_NEED_ACTION_EDIT="修改项目名";L.i_task_dayleft="还剩 {0} 天";L.i_task_overdue="过期 {0} 天";L.i_task_overdues="过期 {0} 天";L.i_task_dueday="今天到期";L.i_tasks_selected="{0}条任务";L.I_TASKS_INPUT_NUMBER="请输入数字";L.I_TASKS_INPUT_NUMBER_0="请输入大于0的数字";L.i_message_invite_by_str="发自 {0} 的联系人申请";L.i_message_request_friend="{0} 申请加你为Doit.im联系人。";L.i_message_agree="同意";L.i_message_refuse="忽略";L.i_message_agree_return="备注：您已同意其联系人申请，现在已经可以在Doit.im中相互转发任务了。";L.i_message_refuse_return="备注：您已忽略其联系人申请，故无法相互转发任务。";L.i_message_invitation_passed_str="{0} 通过了您的联系人申请";L.i_message_invitation_rejected_str="{0} 未通过您的联系人申请";L.i_message_can_forward="备注：现在你们可以相互转发任务了。";L.i_message_forwarded_by_str="由 {0} 转发";L.i_message_forwarded_complete_str="{0} 完成了您转发的任务";L.i_message_forwarded_deleted_by_str="{0} 删除了转发给您的任务";L.i_message_forwarded_complete="所有人完成了您转发的任务";L.I_MESSAGE_FORWARDED_OWNER_FINISH_STR="{0} 完成了转发给您的任务";L.I_SETTING_PREFERENCE_SUCCESS="偏好设置成功";L.I_SETTING_PROFILE_SUCCESS="个人信息设置成功";L.I_SETTING_CHANGE_PASSWORD_SUCCESS="密码修改成功";L.I_SETTING_CHANGE_PASSWORD_FAILED="密码修改失败";L.I_SETTING_WRONG_PASSWORD="当前密码有误";L.I_SETTING_TAGS_DELETE_SUCCESS="标签删除成功";L.I_SETTING_TAGS_DELETE_FAILED="标签删除失败";L.I_SETTING_REMIND_EMAIL_BUTTON="发送确认链接";L.I_SETTING_MAIL_SENT_SUCCESSFULLY="邮件成功发送，请前往确认";L.I_SETTING_REMIND_EMAIL_SEND_FAILED="邮件发送失败，请重试";L.I_SETTING_NICKNAME_REQUIRED="昵称必填";L.I_SETTING_CONNECTED="已关联到Google日历";L.I_SETTING_LINK_TO_GOOGLE_CAL="同步到Google日历";L.I_SETTING_CONNECTED_SUCCESSFULLY="关联成功";L.I_SETTING_UNLINK_CONNECTED_FAILED="取消关联失败";L.I_SETTING_CONNECTED_FAILED=">_< 哎呦，请求关联失败。请多试一次吧。";L.i_contact_newgroup="新群组";L.i_contact_form_edit_title="编辑联系人";L.i_contact_del_group="确定删除此联系人组“{0}”？该组成员在“所有联系人“组中仍保留。";L.i_contact_del_contact="确定删除此联系人？";L.I_TASK_ADD_DUETODAY="本任务今日到期，故存于‘今日待办’。";L.i_search_no_result="未找到任何相关任务。";L.E_ACCOUNT_REQUIRED="用户名必填";L.E_ACCOUNT_INVALID="用户名无效";L.E_ACCOUNT_EXIST="该用户名已被注册 <span class='melogin'>(<a href='/signin?account={0}'> 是我！登录 </a>)</span>";L.E_ACCOUNT_EXIST_MOBILE="该用户名已被注册";L.E_NICKNAME_REQUIRED="昵称必填";L.E_NICKNAME_INVALID="昵称无效";L.E_USERNAME_REQUIRED="邮箱地址必填";L.E_USERNAME_INVALID="邮箱地址无效";L.E_USERNAME_EXIST="该邮箱已被注册 <span class='melogin'>(<a href='/signin?username={0}'> 是我！登录 </a>)</span>";L.E_USERNAME_EXIST_MOBILE="该邮箱已被注册";L.E_PASSWORD_REQUIRED="密码必填";L.E_6_OR_MORE_CHAR="密码不足6位";L.E_PRIVACY="是否理解并愿意遵守Doit.im服务条款和隐私政策?";L.E_USERNAME_TIP="32位及以下英文、数字、下划线";L.E_PASSWORD_TIP="6位及以上字符";L.Hotkey_TITLE="快捷键";L.Hotkey_SUBTITLE_ACTIOINS="操作";L.Hotkey_SUBTITLE_NAV="导航";L.Hotkey_PREVIOUS="上一条任务";L.Hotkey_NEXT="下一条任务";L.Hotkey_OPEN="打开任务";L.Hotkey_BACKTOLIST="任务详细页返回任务列表";L.Hotkey_EDIT="编辑任务";L.Hotkey_NEW="新增任务";L.Hotkey_PRIORITY="调整任务优先级";L.Hotkey_COMPLETE="完成任务";L.Hotkey_DELETE="删除任务列表选中的任务";L.Hotkey_GOTOINBOX="跳转到收集箱";L.Hotkey_GOTOTODAY="跳转到今日待办";L.Hotkey_GOTONEXT="跳转到下一步行动";L.Hotkey_GOTOSCHEDULE="跳转到日程";L.Hotkey_GOTOWAITING="跳转到等待";L.Hotkey_GOTOPROJECTS="跳转到全部项目";L.Hotkey_FULLSCREEN="全屏任务列表模式";L.Hotkey_SELECTRANGE="点击选择范围内任务";L.Hotkey_SELECTMULTI="点击多选任务";L.TASKFORM_NO_RESULTS="无相关结果。";L.TASKFORM_SAVE="保存";L.TASKFORM_NOT_CONTACT="TA尚未成为您的联系人，请先添加。";L.TASKFORM_TASK_SEND_FALSE="咦，连接失败啦？请重试。";if(typeof($.datepicker)!="undefined"){$.datepicker.regional["zh-CN"]={closeText:"关闭",prevText:"&#x3c;上月",nextText:"下月&#x3e;",currentText:"今天",monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],dayNamesShort:["周日","周一","周二","周三","周四","周五","周六"],dayNamesMin:["日","一","二","三","四","五","六"],weekHeader:"周",dateFormat:"yy-mm-dd",firstDay:0,isRTL:false,showMonthAfterYear:false,yearSuffix:""};$.datepicker.setDefaults($.datepicker.regional["zh-CN"])}L.ADD_CONTACT="联系人申请已发送，等待对方确认。";L.OPERATION_IS_PERMANNENT="（此操作不可逆）";L.ALREADY_BEEN_CONTACT="TA 已经是你的联系人了";L.DELETE_CONTACT_SUCCESS="联系人删除成功";L.DELETE_CONTACT_FROM_GROUP_SUCCESS="联系人从改组删除成功";L.CONTACT_GROUP_EXIST="联系人组已存在";L.CONTACT_GROUP_ADD_SUCCESS="新增联系人分组成功";L.INPUT_NEW_CONTACT_GROUP_NAME="请输入一个新组名";L.DATEPICKER_UNSET="不设置";L.DATEPICKER_OK="确定";L.ALL_CONTACT_GROUP="所有联系人";L.UNABLE_ADD_SELF="无法添加自己为联系人";L.TIPS_TASK_UPDATE_OK="任务更新成功";L.TITLE_REQUIRED="标题必填";L.TITLE_LESS_255="标题须在255位及以下";L.TIPS_REPEAT_CHILD_CANT_SET="重复任务的系列任务中无法修改重复策略，请您到日程中修改。";L.TIME_END_AT="截止于 ";L.TIME_END_ON="截止于 ";L.ACTIVE="激活";L.INACTIVE="冻结";L.MYSELF="我";L.REPEAT_WAITING_FOR="等待，";L.UPDATE_CONTACT_SUCCESS="联系人信息更新成功。";L.CONTACT_DELETED="被删除联系人";L.SMARTFOLDER_SPACE=" ";L.SMARTFOLDER_STATUS="状态：";L.SMARTFOLDER_STATUS_COMP="已完成";L.SMARTFOLDER_STATUS_NOCOMP="未完成";L.SMARTFOLDER_PRIORITY="优先级：";L.SMARTFOLDER_PRIORITY_N="无";L.SMARTFOLDER_PRIORITY_L="低";L.SMARTFOLDER_PRIORITY_M="中";L.SMARTFOLDER_PRIORITY_H="高";L.SMARTFOLDER_GROUPBY="分组依据：";L.SMARTFOLDER_SORTBY="排序：";L.SMARTFOLDER_STARTTIME="开始时间：";L.SMARTFOLDER_TIME_SPACE="";L.SMARTFOLDER_TIME_FROM="第";L.SMARTFOLDER_TIME_TO="到";L.SMARTFOLDER_TIME_DAY="天";L.SMARTFOLDER_TIME_ST="";L.SMARTFOLDER_TIME_ND="";L.SMARTFOLDER_DEADLINE="截止时间：";L.SMARTFOLDER_CONTECTS="情境：";L.SMARTFOLDER_PROJECTS="项目：";L.SMARTFOLDER_TAGS="标签：";L.SMARTFOLDER_BY="转发自：";L.SMARTFOLDER_TO="转发给：";L.SMARTFOLDER_TITLELIMIT="标题限制为6位中文或12位英文";L.SMARTFOLDER_EXISTNAME="自定义箱子名称已存在";L.CONTACT_CHOOSE_GROUP="请选择一个分组";L.CONTACT_CHOOSE_CONTACT="请选择一个联系人";L.NOTICE_NEW_VERSION="新版发布";L.NOTICE_ACTIVE_EMAIL_TITLE="您还未激活您的注册邮箱！";L.NOTICE_ACTIVE_EMAIL="请前往 {0} 确认您的注册邮箱，确认后方能启动邮件提醒功能。";L.NOTICE_ACTIVE_EMAIL3="邮件未收到？<br />若在垃圾箱也未找到，请点击 ";L.NOTICE_ROGER="我知道了";L.NOTICE_RESEND="再次发送";L.EDIT_SMART_BOX="编辑";L.HAPPY2012_1="公元2012年12月5日";L.HAPPY2012_2="地球逃离计划";L.FIREROCKET="火箭正在点火中！";L.GOODBYEEARTH="再见，地球人！";L.BACKTOEARTH="回归地球!";L.HAPPY41="";L.E028="重复任务不能设置绝对提醒。";L.AJAX_400="";L.AJAX_401=">_< 哎呦，您已经登出了Doit.im，系统将为您在5秒后自动跳到登录页面，请重新登录。";L.AJAX_500="哎呦，抱歉...您的帐号异常或者服务器内部错误，请几秒钟后重试，或者在「服务支持」里联系我们。";L.AJAX_502="哎呦，抱歉...服务器过于忙碌，暂时无法完成您的请求，请几秒钟后重试。";L.AJAX_TIMEOUT="哎呦，您当前访问Doit.im网络非常缓慢或者您的本地网络异常，已经连接超时，请确认您当前的网络状况并重试或者刷新页面...";L.AJAX_ERROR="哎呦，异常错误或者您的本地网络异常，请确认您当前的网络状况并于几秒钟后重试...";L.AJAX_UNKNOWN="哎呦，抱歉...服务器异常错误，请几秒钟后重试，或者在「服务支持」里联系我们。";L.setting_del_account="删除本账号";L.setting_del_account_confirm1="你要离开我们了？若你删除了账号，你在Doit.im上的所有记录都将被删去，一切都将无法挽回。你确定要离开？";L.setting_del_account_confirm1_yes="是的，请删除我的账号";L.setting_del_account_confirm1_no="不，是我不小心点到";L.setting_del_account_confirm2="你是铁了心要走？";L.setting_del_account_confirm2_yes="是的";L.setting_del_account_confirm2_no="不，再让我想想";L.setting_del_account_confirm3_yes="希望你能发邮件到 contact@snoworange.com 告诉我们你离开的原因，我们需要你的帮助。";L.setting_del_account_confirm3_no="如果有任何想法，你可以随时通过网站右上角‘反馈’或发邮件到 contact@snoworange.com 告诉我们。";L.MESSAGE_PUTBACK_EXISTPROJECT="已存在同名项目，请修改项目名。 ";L.MESSAGE_TASK_NOTIN_PROJECT_DATE="本任务起止时间未包含在其所属项目的时间段（{0}）内，请调整。";L.MESSAGE_PROJECT_NOT_CONTAIN_TASKS="该项目起止时间未能涵盖以下下属任务的时间段，请调整。";L.MESSAGE_DUEDAY_PROJECT_ACTIVE1="项目“";L.MESSAGE_DUEDAY_PROJECT_ACTIVE2="”中以下任务今天开始，是否激活该项目？";L.MESSAGE_DUEDAY_PROJECT_ACTIVE_TIPS="（激活后，项目下的任务才会在相应时间箱子显示）";L.TEXTTIPS_PROJECT_NOT_EXIST="该项目不存在或者已被删除。";L.TEXTTIPS_CONTEXT_NOT_EXIST="该情境不存在或者已被删除。";L.REFRESH_CURRENT_BOX="重新加载任务列表";L.REFRESH_TASK="重新加载任务评论";