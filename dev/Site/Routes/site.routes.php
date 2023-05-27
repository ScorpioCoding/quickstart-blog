<?php

return (object) array(

  '/frontend'   => [
    'lang' => 'en',
    'module' => 'Site',
    'namespace' => 'Modules\Site\Controllers',
    'controller' => 'Home',
    'action' => 'index'
  ],

  '/home'   => [
    'lang' => 'en',
    'module' => 'Site',
    'namespace' => 'Modules\Site\Controllers',
    'controller' => 'Home',
    'action' => 'index'
  ],


  '/{lang}/home'   => [
    'module' => 'Site',
    'namespace' => 'Modules\Site\Controllers',
    'controller' => 'Home',
    'action' => 'index'
  ],

  '/{lang}/Blog' => [
    'module' => 'Site',
    'namespace' => 'Modules\Site\Controllers',
    'controller' => 'Blog',
    'action' => 'index'
  ],

  '/{lang}/Posts/slug/{slug}' => [
    'module' => 'Site',
    'namespace' => 'Modules\Site\Controllers',
    'controller' => 'Posts',
    'action' => 'index'
  ],

  '/{lang}/Posts/id/{id:\d+}' => [
    'module' => 'Site',
    'namespace' => 'Modules\Site\Controllers',
    'controller' => 'Posts',
    'action' => 'index'
  ],



);
