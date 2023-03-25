<?php

namespace Controllers;

use MVC\Router;


class DashboardController
{
  public static function index(Router $router)
  {
    session_start();
    isAuth();

    $router->render('dashboard/index', [
      'title' => 'Proyectos',
    ]);
  }

  public static function create_project(Router $router)
  {
    session_start();
    isAuth();
    $alerts = [];

    



    $router->render('dashboard/create-project', [
      'title' => 'Crear Proyecto',
      'alerts' => $alerts,
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
