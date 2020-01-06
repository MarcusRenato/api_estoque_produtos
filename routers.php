<?php
global $routes;
$routes = array();

$routes['/login']   = '/user/login';
$routes['/create']  = '/user/create';

$routes['/products/create'] = '/product/create';
$routes['/products'] = '/product/getAllProducts';
$routes['/products/{id}']   = '/product/view/:id';