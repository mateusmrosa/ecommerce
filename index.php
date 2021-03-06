<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

//rota para parte publica www.ecommerce.com.br
$app->get('/', function () {

	$page = new Page();

	$page->setTpl("index");
});

//rota para parte privada (adm) www.ecommerce.com.br/admin
$app->get('/admin', function () {

	//print_r($_SESSION);

	User::verifyLogin();

	$pageAdmin = new PageAdmin();

	$pageAdmin->setTpl("index");
});

//rota para parte login (admin) www.ecommerce.com.br/admin/login
$app->get('/admin/login', function () {

	$pageAdmin = new PageAdmin([
		"header" => false,
		"footer" => false,
	]);

	$pageAdmin->setTpl("login");
});

$app->post("/admin/login", function () {

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function () {

	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->get('/admin/users', function () {

	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl('users', array(
		"users" => $users
	));
});

$app->get('/admin/users/create', function () {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('users-create');
});

$app->get("/admin/users/:iduser/delete", function ($iduser) {

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");

	exit;

});


$app->get('/admin/users/:iduser', function ($iduser) {

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl('users-update', array(
		"user" => $user->getValues()
	));
});


$app->post("/admin/users/create", function () {

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$user->setData($_POST);

	$user->save();

	header("Location: /admin/users");

	exit;
});


$app->post("/admin/users/:iduser", function ($iduser) {

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");

	exit;
});


// $app->get("/teste", function () {

// 	$dtLimite = date("d/m/Y", strtotime("now"));
// 	// $dataFase = "18/02/2022";
// 	var_dump($dtLimite);
// 	// if ($dtLimite > $dataFase)
// 	// 	var_dump(true);
// 	// else
// 	// 	var_dump(false);

// 	$dataAtual = date('Y-m-d');
// });


$app->run();
