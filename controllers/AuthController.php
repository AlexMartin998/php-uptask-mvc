<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController
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
          // // create new user
          // hash pass
          $user->hashPassword();

          // clear user active record
          unset($user->password2);

          $user->createTempToken();

          $result = $user->save();

          // send email
          $email = new Email($user->email, $user->name, $user->token);
          $email->sendConfirmationEmail();


          if ($result) header('Location: /message');
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
    $token = s($_GET['token']);
    if (!$token) header('Location: /');

    $user = User::where('token', $token);
    if (empty($user)) {
      User::setAlert('error', 'Invalid token!');
    } else {
      // confirm account
      $user->confirmed = 1;
      $user->token = null;
      unset($user->password2);

      $user->save();

      User::setAlert('success', 'Cuenta comporbada correctamente');
    }

    $alerts = User::getAlerts();


    // render view
    $router->render('auth/confirm-account', [
      'title' => 'Confirma tu cuenta UpTask',
      'alerts' => $alerts
    ]);
  }
}
