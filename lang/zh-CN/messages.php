<?php

return [
	'welcome'              => '你好，世界！',
	'succeed'              => '成功',
	'failed'               => '失败',
	'true'                 => '是',
	'false'                => '否',
	'login'                => [
		'auth_fail'    => '账户或密码不正确',
		'success'      => '登录成功',
		'out'          => '成功退出登录',
		'not_token'    => '您尚未登陆或者您的登陆信息已失效！',
		'QQ'           => 'QQ',
		'weibo'        => '微博',
		'gitee'        => '码云',
		'github'       => 'github',
		'register'     => '注册账号',
		'verify_login' => '验证码登录',
		'repass'       => '密码重置',
	],
	'permission'           => [
		'exists'     => '权限已存在，无需重复添加',
		'not'        => '权限不足，无法访问',
		'menu'       => '菜单',
		'permission' => '权限',
	],
	'has_child'            => '该数据下存在子级，请先删除',
	'admin_can_not_delete' => '该管理员不允许删除',
	'role_can_not_delete'  => '该角色不允许删除',
	'exception'            => [
		'error'     => '操作失败，请联系管理员！',
		'parameter' => '参数错误！',
		'resource'  => '资源不存在！',
	],
	'http_status'          => [
		'ok'                 => '成功',
		'created'            => '创建成功',
		'accepted'           => '已接收',
		'bad'                => '客户端请求错误',
		'unauthorized'       => '未授权',
		'payment'            => '未付款',
		'forbidden'          => '拒绝访问',
		'param_bad'          => '参数错误',
		'error'              => '服务错误',
		'not_found'          => '资源不存在',
		'method_not_allowed' => '请求方式不存在',
		'unavailable'        => '服务不可用',
	],
	'file_upload'          => [
		'local'  => '本地',
		'aliyun' => '阿里云',
		'qiniu'  => '七牛云',
	],
	'sms'                  => [
		'alibaba' => '阿里云',
		'tencent' => '腾讯云',
		'huawei'  => '华为云',
		'qiniu'   => '七牛云',
	],
];