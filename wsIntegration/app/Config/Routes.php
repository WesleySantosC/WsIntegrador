<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Página inicial
$routes->get('/', 'Home::index');

//Página de contatos
$routes->get('/contact', 'Contact::index');
$routes->post('/contact/submit', 'Contact::submit');

//Páginas de login
$routes->get('/login', 'Login::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/login/verifyUsers', 'Login::verifyUsers');

//Página de registros
$routes->get('/register', 'Register::index');
$routes->post('/register/store', 'Register::store');

//Página de dados
$routes->get('/dataClient', 'DataClient::index');

//Página de cadastro de imóveis
$routes->get('/cadastrarImovel', 'CadastraImovel::index');
$routes->post('/cadastrarImovel/validateField', 'CadastraImovel::validateField');


//Página de teste com o banco.
$routes->get('testeconexao', 'TesteConexao::index');