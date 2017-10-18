<?php 

//controller allowed actions for all users
$controllers = array(
						'pages' => ['index', 'error'],
						'users' => ['index', 'create', 'edit', 'save', 'postEdit', 'delete', 'editAuth', 'postEditAuth'],
						'auth' => ['login', 'postLogin', 'logout'],
						'msg' => ['send']
					);

 ?>