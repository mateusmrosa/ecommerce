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

$app->run();
