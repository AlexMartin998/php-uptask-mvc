<?php

namespace Controllers;

use Model\Project;
use Model\Task;
use MVC\Router;

class TaskController
{

  public static function index()
  {
    session_start();
    isAuth();
  }

  public static function create_task()
  {
    session_start();
    isAuth();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $resp = [];
      $projectUrl =  $_POST['project_id'];
      $project = Project::where('url', $projectUrl);

      if (!$project || $project->owner_id !== $_SESSION['id']) {
        $resp = [
          'ok' => false,
          'type' => 'error',
          'message' => 'Se produjo un error al agregar la tarea',
        ];

        echo json_encode($resp);
        return;
      }

      $task = new Task($_POST);
      $task->project_id = $project->id;
      $result = $task->save();

      $resp = [
        'ok' => true,
        'type' => 'success',
        'id' => $result['id'],
        'message' => 'Tarea creada correctamente.',
      ];
      echo json_encode($resp);
    }
  }

  public static function update_task()
  {
    session_start();
    isAuth();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }
  }

  public static function delete_task()
  {
    session_start();
    isAuth();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }
  }
}
