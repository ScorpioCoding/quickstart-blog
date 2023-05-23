<?php

return (object) array(


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



);
