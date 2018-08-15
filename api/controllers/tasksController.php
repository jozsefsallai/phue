<?php

class TasksController {
  public static $tasksFile = '../example/tasks.json';

  public static function get($req, $res) {
    $contents = file_get_contents(self::$tasksFile);
    $json = json_decode($contents, true);

    $tasks = array('ok' => true, 'records' => $json['tasks']);

    return $res->json($tasks);
  }

  public static function create($req, $res) {
    $contents = file_get_contents(self::$tasksFile);
    $oldData = json_decode($contents, true);

    $name = $req['body']['name'];
    if (!$name) {
      http_response_code(422);
      return $res->json(array(
        'ok' => false,
        'error' => 'Task name not provided!'
      ));
    }

    $tasksCount = count($oldData['tasks']);
    $newTaskId = $tasksCount ? $oldData['tasks'][$tasksCount - 1]['id'] + 1 : 0;

    $newTask = array(
      'id' => $newTaskId,
      'name' => $name,
      'done' => false
    );

    array_push($oldData['tasks'], $newTask);

    $newData = json_encode($oldData, JSON_PRETTY_PRINT);

    if (file_put_contents(self::$tasksFile, $newData)) {
      $json = array('ok' => true, 'record' => $newTask);
      return $res->json($json);
    }
  }

  public static function update($req, $res) {
    $contents = file_get_contents(self::$tasksFile);
    $oldData = json_decode($contents, true);

    $taskId = $req['params']['id'];

    $name = $req['body']['name'];
    if (!$name) {
      http_response_code(422);
      return $res->json(array(
        'ok' => false,
        'error' => 'Task name not provided!'
      ));
    }

    $targetTask = array_search($taskId, array_column($oldData['tasks'], 'id'));

    if (!isset($targetTask)) {
      http_response_code(500);
      return $res->json(array(
        'ok' => false,
        'error' => 'Task not found'
      ));
    }

    $oldData['tasks'][$targetTask]['name'] = $name;

    $newData = json_encode($oldData, JSON_PRETTY_PRINT);

    if (file_put_contents(self::$tasksFile, $newData)) {
      $json = array('ok' => true, 'record' => $oldData['tasks'][$targetTask]);
      return $res->json($json);
    }
  }

  public static function changeState($req, $res) {
    $contents = file_get_contents(self::$tasksFile);
    $oldData = json_decode($contents, true);

    $taskId = $req['params']['id'];
    $taskState = $req['params']['state'];

    if ($taskState !== 'done' && $taskState !== 'pending') {
      http_response_code(500);
      return $res->json(array(
        'ok' => false,
        'error' => 'Invalid task state.'
      ));
    }

    $newState = $taskState == 'done' ? true : false;
    $targetTask = array_search($taskId, array_column($oldData['tasks'], 'id'));

    if (!isset($targetTask)) {
      http_response_code(500);
      return $res->json(array(
        'ok' => false,
        'error' => 'Task not found'
      ));
    }

    $oldData['tasks'][$targetTask]['done'] = $newState;
    
    $newData = json_encode($oldData, JSON_PRETTY_PRINT);

    if (file_put_contents(self::$tasksFile, $newData)) {
      $json = array('ok' => true, 'record' => $oldData['tasks'][$targetTask]);
      return $res->json($json);
    }
  }

  public static function destroy($req, $res) {
    $contents = file_get_contents(self::$tasksFile);
    $oldData = json_decode($contents, true);

    $taskId = $req['params']['id'];

    $record = $oldData['tasks'][$taskId];
    unset($oldData['tasks'][$taskId]);
    $oldData['tasks'] = array_values($oldData['tasks']);

    $newData = json_encode($oldData, JSON_PRETTY_PRINT);

    if (file_put_contents(self::$tasksFile, $newData)) {
      $json = array('ok' => true, 'record' => $record);
      return $res->json($json);
    }
  }
}

?>
