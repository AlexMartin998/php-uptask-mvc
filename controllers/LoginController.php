<?php

namespace Controllers;

use MVC\Router;

class LoginController
{
  public static function login(Router $router)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }

    // render view
    $router->render('auth/login', [
      'title' => 'Iniciar Sesión',
    ]);
  }

  public static function logout()
  {
    echo "from logout";
  }

  public static function register(Router $router)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }

    // render view
    $router->render('auth/register', [
      'title' => 'Crea tu cuenta en UpTask',
    ]);
  }

  public static function forgotPassword(Router $router)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }

    // render view
    $router->render('auth/forgot-password', [
      'title' => 'Olvide mi password',
    ]);
  }

  public static function resetPassword(Router $router)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }

    // render view
    $router->render('auth/reset-password', [
      'title' => 'Reestablecer Password',
    ]);
  }

  public static function message(Router $router)
  {
    // render view
    $router->render('auth/message', [
      'title' => 'Cuenta Creada Exitosamente',
    ]);
  }

  public static function confirmAccount(Router $router)
  {
    // render view
    $router->render('auth/confirm-account', [
      'title' => 'Confirma tu cuenta UpTask',
    ]);
  }
}
