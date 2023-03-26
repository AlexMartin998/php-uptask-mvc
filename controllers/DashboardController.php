<?php

namespace Controllers;

use Model\Project;
use Model\User;
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
    $user = User::find($_SESSION['id']);
    $alerts = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->synchronize($_POST);
      $alerts = $user->validateProfile();

      if (empty($alerts)) {
        // check email
        $isRegisterd = User::where('email', $user->email);

        if ($isRegisterd && $isRegisterd->id !== $user->id) {
          User::setAlert('error', 'Cuenta ya registrada.');
        } else {
          $user->save();
          $_SESSION['name'] = $user->name;

          User::setAlert('success', 'Cambios guardados correctamente');
        }
      }
    }

    $alerts = $user->getAlerts();

    $router->render('dashboard/profile', [
      'title' => 'Perfil',
      'user' => $user,
      'alerts' => $alerts,
    ]);
  }

  public static function update_password(Router $router)
  {
    session_start();
    isAuth();
    $user = User::find($_SESSION['id']);
    $alerts = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->synchronize($_POST);
      $alerts = $user->newPassValidations();

      if (empty($alerts)) {
        $result = $user->checkNewPassword();
        if ($result) {
          $user->password = $user->new_password;
          unset($user->password2, $user->new_password);

          $user->hashPassword();
          $saveResult = $user->save();

          if ($saveResult) {
            User::setAlert('success', 'Password Actualizado Correctamente');
          }
        } else {
          User::setAlert('error', 'Password Incorrecto');
        }
      }
    }

    $alerts = $user->getAlerts();

    $router->render('dashboard/update-password', [
      'title' => 'Cambiar Password',
      'alerts' => $alerts,
    ]);
  }
}
