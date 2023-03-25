<?php

namespace Controllers;

use Model\Project;
use MVC\Router;


class DashboardController
{
  public static function index(Router $router)
  {
    session_start();
    isAuth();

    $projects = Project::belongsTo('owner_id', $_SESSION['id']);

    $router->render('dashboard/index', [
      'title' => 'Proyectos',
      'projects' => $projects,
    ]);
  }

  public static function create_project(Router $router)
  {
    session_start();
    isAuth();
    $alerts = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = new Project($_POST);
      $alerts = $project->validateProjectInputs();

      if (empty($alerts)) {
        $project->url = md5(uniqid());
        $project->owner_id = $_SESSION['id'];

        $project->save();

        header('Location: /proyecto?id=' . $project->url);
      }
    }


    $router->render('dashboard/create-project', [
      'title' => 'Crear Proyecto',
      'alerts' => $alerts,
    ]);
  }

  public static function project(Router $router)
  {
    session_start();
    isAuth();

    $projectUrl = $_GET['id'];
    if (!$projectUrl) header('Location: /dashboard');

    // check project owner
    $project = Project::where('url', $projectUrl);
    if ($project->owner_id !== $_SESSION['id']) header('Location: /dashboard');




    $router->render('dashboard/project', [
      'title' => $project->title,
    ]);
  }

  public static function profile(Router $router)
  {
    session_start();
    isAuth();

    $router->render('dashboard/create-project', [
      'title' => 'Perfil',
    ]);
  }
}
