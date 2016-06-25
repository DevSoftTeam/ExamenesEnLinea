<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('testquestion_index', new Route(
    '/',
    array('_controller' => 'EvaluationsBundle:TestQuestion:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('testquestion_show', new Route(
    '/{id}/show',
    array('_controller' => 'EvaluationsBundle:TestQuestion:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('testquestion_new', new Route(
    '/new',
    array('_controller' => 'EvaluationsBundle:TestQuestion:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('testquestion_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'EvaluationsBundle:TestQuestion:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('testquestion_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'EvaluationsBundle:TestQuestion:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
