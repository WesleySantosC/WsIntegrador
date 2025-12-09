<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Página inicial
$routes->get('/', 'Home::index');

//Página de contatos
$routes->get('/contact', 'Contact::index');
$routes->post('/contact/registerContact', 'Contact::registerContact');

//Páginas de login
$routes->get('/login', 'Login::index');
$routes->post('/login/verifyUsers', 'Login::verifyUsers');
$routes->post('/login/logout', 'Login::logout');

//Páginas do dashBoard
$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/dashboard/desativaImovel', 'Dashboard::disableRealty');
$routes->post('/dashboard/activeRealty', 'Dashboard::activeRealty');

//Página de editar senha
$routes->get('/resetPassword', 'RegisterNewPassword::index');
$routes->post('/resetPassword', 'RegisterNewPassword::resultStatus');

/*API Do XML para Plataforma de terceiros fazerem requisição*/
$routes->get('xml/user_(:num).xml', 'ApiXml::showXmlForTheThirdPlataform/$1');

/* Página de Editar os Anúncios*/
$routes->get("edit/(:num)", "EditAds::edit/$1");
$routes->match(['get','post'], "edit/editAds", "EditAds::editAds");


//Página de dados
$routes->get('/dataClient', 'DataClient::index');

//Página de cadastro de imóveis
$routes->get('/cadastrarImovel', 'CadastraImovel::index');
$routes->post('/cadastrarImovel/validateField', 'CadastraImovel::validateField');

//Página de gerar xml
$routes->get('/generateLinkXml', 'GenerateLinkXml::index');
$routes->post('/generateLinkXml', 'GenerateLinkXml::index');
$routes->post('generateLinkXml/generate', 'GenerateLinkXml::generate');

//pagina de planos
$routes->get('/plans', 'Plans::index');

//Pagamentos
$routes->match(['get', 'post'], '/payment/returnStatus', 'PaymentController::returnStatus');
$routes->get('/payment/(:num)', 'PaymentController::choose/$1');

// Página de Mensalidades
$routes->get('/monthlyFee', 'MonthlyFee::index');

//Página de teste com o banco.
$routes->get('testeconexao', 'TesteConexao::index');

//Teste requisição Asaas via webhook.
$routes->post('webhook', 'AsaasWebhook::index');