<?php 

//controller allowed actions for all users
$controllers = array(
						'pages' => ['index', 'error'],
						'auth' => ['login', 'postLogin', 'logout']
					);
//admin authorized
$controllers_ad = array(
						'pages' => ['index', 'error'],
						'users' => ['index', 'create', 'edit', 'save', 'postEdit', 'delete', 'editAuth', 'postEditAuth'],
						'auth' => ['login', 'postLogin', 'logout', 'onlineAll'],
						'msg' => ['save', 'index', 'allMsg', 'newMsg', 'search', 'searchPost'],
						'keywords' => ['save']
					);
//standard user autherized 
$controllers_st = array(
						'pages' => ['index', 'error'],
						'users' => ['index', 'create', 'edit', 'save', 'postEdit', 'delete', 'editAuth', 'postEditAuth'],
						'auth' => ['login', 'postLogin', 'logout', 'onlineAll'],
						'msg' => ['save', 'index', 'allMsg', 'newMsg', 'search', 'searchPost'],
						'keywords' => ['save']
					);

 ?>