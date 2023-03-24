<?php

namespace Controllers;

use Model\User;
use MVC\Router;

class AuthController
{
  public static function login(Router $router)
  {
    $user = new User;

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
    $alerts = [];
    $user = new User;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->synchronize($_POST);
      $alerts = $user->registrationValidations();

      if (empty($alerts)) {
        $isAlreadyRegistered = User::where('email', $user->email);

        if ($isAlreadyRegistered) {
          User::setAlert('error', 'El Usuario ya esta registrado');
          $alerts = User::getAlerts();
        } else {
          // create new user
          debugging($user);
        }
      }
    }

    // render view
    $router->render('auth/register', [
      'title' => 'Crea tu cuenta en UpTask',
      'user' => $user,
      'alerts' => $alerts,
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
