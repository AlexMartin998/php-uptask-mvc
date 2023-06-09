<?php

namespace Model;

class User extends ActiveRecord
{
  protected static $table = 'users';
  protected static $dbColumns = ['id', 'name', 'email', 'password', 'token', 'confirmed'];


  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->password2 = $args['password2'] ?? '';
    $this->new_password = $args['new_password'] ?? '';
    $this->token = $args['token'] ?? '';
    $this->confirmed = $args['confirmed'] ?? 0;
  }

  // checkLogin
  public function checkLogin()
  {
    if (!$this->email) {
      self::$alerts['error'][] = 'El Email del Usuario es Obligatorio';
    }
    if (strlen($this->password) < 6) {
      self::$alerts['error'][] = 'El password debe contener al menos 6 caracteres';
    }
    if (!$this->password) {
      self::$alerts['error'][] = 'El Password no puede ir vacio';
    }

    return self::$alerts;
  }

  // user registration validations
  public function registrationValidations()
  {
    if (!$this->name) {
      self::$alerts['error'][] = 'El Nombre del Usuario es Obligatorio';
    }
    if (!$this->email) {
      self::$alerts['error'][] = 'El Email del Usuario es Obligatorio';
    }
    if (!$this->password) {
      self::$alerts['error'][] = 'El Password no puede ir vacio';
    }
    if (strlen($this->password) < 6) {
      self::$alerts['error'][] = 'El password debe contener al menos 6 caracteres';
    }
    if ($this->password !== $this->password2) {
      self::$alerts['error'][] = 'Los password son diferentes';
    }

    return self::$alerts;
  }


  // hash password
  public function hashPassword()
  {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  // gen temp confirm token
  public function createTempToken()
  {
    $this->token = md5(uniqid());
  }

  // validate email
  public function validateEmail()
  {
    if (!$this->email || strlen($this->email) < 5) {
      self::$alerts['error'][] = 'El email es Obligatorio';
    }

    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alerts['error'][] = 'Email invalido';
    }

    return self::$alerts;
  }

  // validate password
  public function validatePassword()
  {
    if (!$this->password) {
      self::$alerts['error'][] = 'El Password no puede ir vacio';
    }
    if (strlen($this->password) < 6) {
      self::$alerts['error'][] = 'El password debe contener al menos 6 caracteres';
    }

    return self::$alerts;
  }

  public function validateProfile()
  {
    if (!$this->name) {
      self::$alerts['error'][] = 'El Nombre del Usuario es Obligatorio';
    }
    if (!$this->email) {
      self::$alerts['error'][] = 'El Email del Usuario es Obligatorio';
    }

    return self::$alerts;
  }

  public function newPassValidations()
  {
    if (!$this->password2) {
      self::$alerts['error'][] = 'El Password Actual es Obligatorio';
    }
    if (!$this->new_password) {
      self::$alerts['error'][] = 'El Password Nuevo es Obligatorio';
    }
    if (strlen($this->new_password) < 6) {
      self::$alerts['error'][] = 'El Password Nuevo debe contener al menos 6 caracteres';
    }

    return self::$alerts;
  }

  public function checkNewPassword()
  {
    return password_verify($this->password2, $this->password);
  }
}
