<?php

namespace Model;

class User extends ActiveRecord
{
  protected static $table = 'users';
  protected static $dbColumns = ['id', 'name', 'email', 'password', 'token', 'confirmed'];


  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['id'] ?? '';
    $this->email = $args['id'] ?? '';
    $this->password = $args['id'] ?? '';
    $this->token = $args['id'] ?? '';
    $this->confirmed = $args['id'] ?? '';
  }
}
