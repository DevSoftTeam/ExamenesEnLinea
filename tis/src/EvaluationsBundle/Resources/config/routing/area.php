<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('area_index', new Route(
    '/',
    array('_controller' => 'EvaluationsBundle:Area:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('area_show', new Route(
    '/{id}/show',
    array('_controller' => 'EvaluationsBundle:Area:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('area_new', new Route(
    '/new',
    array('_controller' => 'EvaluationsBundle:Area:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('area_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'EvaluationsBundle:Area:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('area_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'EvaluationsBundle:Area:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
