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
    array('GET','POST')
));

$collection->add('test_searchResult', new Route(
    '/result',
    array('_controller' => 'EvaluationsBundle:Test:search'),
    array(),
    array(),
    '',
    array(),
    array('GET','POST')
));

$collection->add('test_asign_score', new Route(
    '/asignscore/{idTest}/{idUser}',
    array('_controller' => 'EvaluationsBundle:Test:asignscore'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('test_score_asigned', new Route(
    '/asignscore/{testid}/{idUserAnswer}/{score}',
    array('_controller' => 'EvaluationsBundle:Test:score_asigned'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('test_asign', new Route(
    '/asignar/{idT}/{idQ}/{percent}/{ispenalized}',
    array('_controller' => 'EvaluationsBundle:Test:asign'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('test_asign_edit', new Route(
    '/asignarEdit/{idT}/{idQ}/{percent}/{ispenalized}',
    array('_controller' => 'EvaluationsBundle:Test:asign_edit'),
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

$collection->add('test_convertToPdf', new Route(
    '/{test}/convertToPdf',
    array('_controller' => 'EvaluationsBundle:Test:convertToPdf'),
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

$collection->add('show_qualifications', new Route(
    '/{id}',
    array('_controller' => 'EvaluationsBundle:PayrollQualifications:showPayrollQualifications'),

    array(),
    array(),
    '',
    array(),
    array('GET')
));
return $collection;
