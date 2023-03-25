<?php

namespace Controllers;

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

    if ($_SERVER[''] === 'POST') {
    }
  }

  public static function update_task()
  {
    session_start();
    isAuth();

    if ($_SERVER[''] === 'POST') {
    }
  }

  public static function delete_task()
  {
    session_start();
    isAuth();

    if ($_SERVER[''] === 'POST') {
    }
  }
}
