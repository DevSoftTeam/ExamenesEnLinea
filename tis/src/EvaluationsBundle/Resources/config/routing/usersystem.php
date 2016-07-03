<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('usersystem_index', new Route(
    '/',
    array('_controller' => 'EvaluationsBundle:UserSystem:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('usersystem_show', new Route(
    '/{id}/show',
    array('_controller' => 'EvaluationsBundle:UserSystem:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('usersystem_new', new Route(
    '/new',
    array('_controller' => 'EvaluationsBundle:UserSystem:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('usersystem_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'EvaluationsBundle:UserSystem:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('usersystem_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'EvaluationsBundle:UserSystem:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
