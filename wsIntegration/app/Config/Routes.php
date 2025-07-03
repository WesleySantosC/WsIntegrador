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
$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/login/verifyUsers', 'Login::verifyUsers');
$routes->post('/dashboard/desativaImovel', 'Dashboard::disableRealty');

//Página de registros
$routes->get('/register', 'Register::index');
$routes->post('/register/store', 'Register::store');

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
$routes->match(['get', 'post'], '/payment/createClientAsaas', 'PaymentController::createClientAsaas');
$routes->get('/payment/(:num)', 'PaymentController::choose/$1');

//Página de teste com o banco.
$routes->get('testeconexao', 'TesteConexao::index');