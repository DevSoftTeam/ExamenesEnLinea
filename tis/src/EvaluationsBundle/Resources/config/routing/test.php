<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('test_index', new Route(
    '/',
    array('_controller' => 'EvaluationsBundle:Test:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('test_show', new Route(
    '/{id}/show',
    array('_controller' => 'EvaluationsBundle:Test:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('test_new', new Route(
    '/new',
    array('_controller' => 'EvaluationsBundle:Test:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('test_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'EvaluationsBundle:Test:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('test_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'EvaluationsBundle:Test:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
