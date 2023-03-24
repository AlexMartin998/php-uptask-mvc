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

  public static function forgotPassword()
  {
    echo "from forgotPassword";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }
  }

  public static function resetPassword()
  {
    echo "from resetPassword";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }
  }

  public static function message()
  {
    echo "from message";
  }

  public static function confirmAccount()
  {
    echo "from confirmAccount";
  }
}
