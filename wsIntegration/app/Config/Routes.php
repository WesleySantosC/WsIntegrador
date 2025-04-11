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


//Página de consultas
$routes->get('/consulta', "Consultas::Index");

//Página de agendamentos
$routes->get('/agendar', 'Agendamento::index');
$routes->post('/agendar', 'Agendamento::agendar');


//Página de teste com o banco.
$routes->get('testeconexao', 'TesteConexao::index');