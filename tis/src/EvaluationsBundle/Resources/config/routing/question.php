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


$collection->add('questionfile_edit', new Route(
    '/{id}/editFile',
    array('_controller' => 'EvaluationsBundle:Question:editFile'),
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

$collection->add('orderQuestion_new', new Route(
    '/orderQuestion/{id_type}',
    array('_controller' => 'EvaluationsBundle:OrderQuestion:oqNew'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('orderQuestion_show', new Route(
    '/{id}/showOrQ',
    array('_controller' => 'EvaluationsBundle:OrderQuestion:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('orderQuestion_edit', new Route(
    '/{id}/editOrQ',
    array('_controller' => 'EvaluationsBundle:OrderQuestion:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('orderQuestion_delete', new Route(
    '/{id}/deleteOrQ',
    array('_controller' => 'EvaluationsBundle:OrderQuestion:delete'),
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

$collection->add('trueFalseQuestion_show', new Route(
    '/{id}/showTFQ',
    array('_controller' => 'EvaluationsBundle:trueFalseQuestion:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));


$collection->add('trueFalseQuestion_edit', new Route(
    '/{id}/editTFQ',
    array('_controller' => 'EvaluationsBundle:trueFalseQuestion:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('trueFalseQuestion_delete', new Route(
    '/{id}/deleteTFQ',
    array('_controller' => 'EvaluationsBundle:trueFalseQuestion:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
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

$collection->add('uniqueAnswerQuestion_show', new Route(
    '/{id}/showUAQ',
    array('_controller' => 'EvaluationsBundle:uniqueAnswerQuestion:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('uniqueAnswerQuestion_edit', new Route(
    '/{id}/editUAQ',
    array('_controller' => 'EvaluationsBundle:uniqueAnswerQuestion:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('uniqueAnswerQuestion_delete', new Route(
    '/{id}/deleteUAQ',
    array('_controller' => 'EvaluationsBundle:uniqueAnswerQuestion:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
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

$collection->add('multipleQuestion_show', new Route(
    '/{id}/showMQ',
    array('_controller' => 'EvaluationsBundle:multipleQuestion:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('multipleQuestion_edit', new Route(
    '/{id}/editMQ',
    array('_controller' => 'EvaluationsBundle:multipleQuestion:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('multipleQuestion_delete', new Route(
    '/{id}/deleteMQ',
    array('_controller' => 'EvaluationsBundle:multipleQuestion:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));


$collection->add('matchingQuestion_new', new Route(
    '/matchingQuestion/{id_type}',
    array('_controller' => 'EvaluationsBundle:matchingQuestion:mqNew'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('matchingQuestion_show', new Route(
    '/{id}/showMMQ',
    array('_controller' => 'EvaluationsBundle:matchingQuestion:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));


$collection->add('matchingQuestion_edit', new Route(
    '/{id}/editMMQ',
    array('_controller' => 'EvaluationsBundle:matchingQuestion:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('matchingQuestion_delete', new Route(
    '/{id}/deleteMMQ',
    array('_controller' => 'EvaluationsBundle:matchingQuestion:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));


return $collection;