<?php

foreach (glob('../api/controllers/*.php', GLOB_NOSORT) as $controller) {
  require_once($controller);
}

$homeController = new HomeController();
$tasksController = new TasksController();

$router = new Router();

$router->get('/', array($homeController, 'index'));

$router->get('/api/tasks', array($tasksController, 'get'));
$router->post('/api/tasks', array($tasksController, 'create'));
$router->patch('/api/tasks/:id', array($tasksController, 'update'));
$router->patch('/api/tasks/:state/:id', array($tasksController, 'changeState'));
$router->delete('/api/tasks/:id', array($tasksController, 'destroy'));

$router->get('*', array($homeController, 'index'));

$router->start();

?>
