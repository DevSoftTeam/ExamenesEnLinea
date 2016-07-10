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

$collection->add('questionFile_new', new Route(
    '/fileQuestion/{id_type}',
    /*array('_controller' => 'EvaluationsBundle:Question:fileQuestionNew'),*/
    array('_controller' => 'EvaluationsBundle:Question:fileQuestionNew'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('openQuestion_new', new Route(
    '/openQuestion/{id_type}',
    array('_controller' => 'EvaluationsBundle:OpenQuestion:oqNew'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('openQuestion_show', new Route(
    '/{id}/showOQ',
    array('_controller' => 'EvaluationsBundle:OpenQuestion:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('openQuestion_edit', new Route(
    '/{id}/editOQ',
    array('_controller' => 'EvaluationsBundle:OpenQuestion:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('openQuestion_delete', new Route(
    '/{id}/deleteOQ',
    array('_controller' => 'EvaluationsBundle:OpenQuestion:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

$collection->add('trueFalseQuestion_new', new Route(
    '/trueFalseQuestion/{id_type}',
    array('_controller' => 'EvaluationsBundle:trueFalseQuestion:tfqNew'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));


$collection->add('uniqueAnswerQuestion_new', new Route(
    '/uniqueAnswerQuestion/{id_type}',
    array('_controller' => 'EvaluationsBundle:uniqueAnswerQuestion:uaqNew'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('multipleQuestion_new', new Route(
    '/multipleQuestion/{id_type}',
    array('_controller' => 'EvaluationsBundle:multipleQuestion:mqNew'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));


return $collection;
