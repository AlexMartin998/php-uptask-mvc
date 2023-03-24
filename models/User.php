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
    $this->token = $args['token'] ?? '';
    $this->confirmed = $args['confirmed'] ?? '';
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
}
