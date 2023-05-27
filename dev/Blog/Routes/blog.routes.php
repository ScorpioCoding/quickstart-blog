<?php

return (object) array(

  '/backend' => [
    'lang' => 'en',
    'module' => 'Blog',
    'namespace' => 'Modules\Blog\Controllers',
    'controller' => 'Dashboard',
    'action' => 'index'
  ],

  '/blog/dashboard' => [
    'lang' => 'en',
    'module' => 'Blog',
    'namespace' => 'Modules\Blog\Controllers',
    'controller' => 'Dashboard',
    'action' => 'index'
  ],

  '/blog/posts/{status}' => [
    'lang' => 'en',
    'module' => 'Blog',
    'namespace' => 'Modules\Blog\Controllers',
    'controller' => 'Posts',
    'action' => 'index'
  ],

  '/blog/edit/{id:\d+}' => [
    'lang' => 'en',
    'module' => 'Blog',
    'namespace' => 'Modules\Blog\Controllers',
    'controller' => 'Edit',
    'action' => 'index'
  ],

  '/blog/create' => [
    'lang' => 'en',
    'module' => 'Blog',
    'namespace' => 'Modules\Blog\Controllers',
    'controller' => 'Create',
    'action' => 'index'
  ],






);
