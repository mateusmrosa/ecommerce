<?php

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

//rota para parte publica www.ecommerce.com.br
$app->get('/', function () {

	$page = new Page();

	$page->setTpl("index");

});

//rota para parte privada (adm) www.ecommerce.com.br/admin
$app->get('/admin', function () {

	$pageAdmin = new PageAdmin();

	$pageAdmin->setTpl("index");

});

$app->run();
