<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('question_index', new Route(
    '/',
    array('_controller' => 'EvaluationsBundle:Question:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('question_show', new Route(
    '/{id}/show',
    array('_controller' => 'EvaluationsBundle:Question:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('question_new', new Route(
    '/new',
    array('_controller' => 'EvaluationsBundle:Question:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('question_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'EvaluationsBundle:Question:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('question_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'EvaluationsBundle:Question:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;