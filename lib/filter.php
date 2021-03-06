<?php 

//controller allowed actions for all users
$controllers = array(
						'pages' => ['index', 'error'],
						'auth' => ['login', 'postLogin', 'logout'],
						'users' => ['save']
					);
//admin authorized
$controllers_ad = array(
						'pages' => ['index', 'error'],
						'users' => ['index', 'create', 'edit', 'save', 'postEdit', 'delete', 'editAuth', 'postEditAuth', 'profile', 'changePassword', 'postChangePassword', 'view'],
						'auth' => ['login', 'postLogin', 'logout', 'onlineAll'],
						'msg' => ['save', 'index', 'allMsg', 'newMsg', 'search', 'searchPost', 'searchEnc', 'searchPostEnc', 'decryptMsg', 'delete'],
						'keywords' => ['save']
					);
//standard user autherized 
$controllers_st = array(
						'pages' => ['index', 'error'],
						'users' => ['edit', 'postEdit','profile', 'changePassword', 'postChangePassword', 'view'],
						'auth' => ['login', 'postLogin', 'logout', 'onlineAll'],
						'msg' => ['save', 'index', 'allMsg', 'newMsg', 'search', 'searchPost', 'searchEnc', 'searchPostEnc', 'decryptMsg', 'delete'],
						'keywords' => ['save']
					);

 ?>