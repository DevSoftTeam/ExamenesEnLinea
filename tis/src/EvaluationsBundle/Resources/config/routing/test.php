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

$collection->add('test_asign', new Route(
    '/asignar/{idT}/{idQ}',
    array('_controller' => 'EvaluationsBundle:Test:asign'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('test_preview', new Route(
    '/{id}/preview',
    array('_controller' => 'EvaluationsBundle:Test:preview'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('test_asosiation', new Route(
    '/{id}/asignar',
    array('_controller' => 'EvaluationsBundle:Test:asosiation'),
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


$collection->add('test_drop', new Route(
    '/drop/{idT}/{idQ}',
    array('_controller' => 'EvaluationsBundle:Test:drop'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));
$collection->add('test_data', new Route(
    '/{id}/show',
    array('_controller' => 'EvaluationsBundle:Test:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));
return $collection;
