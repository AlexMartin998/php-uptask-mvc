<?php

namespace Model;

use Model\ActiveRecord;

class Project extends ActiveRecord
{
  protected static $table = 'projects';
  protected static $dbColumns = ['id', 'title', 'url', 'owner_id'];

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->title = $args['title'] ?? '';
    $this->url = $args['url'] ?? '';
    $this->owner_id = $args['owner_id'] ?? '';
  }

  // validations
  public function validateProjectInputs()
  {
    if (!$this->title) self::$alerts['error'][] = 'El Nombre del Proyecto es Obligatorio';

    return self::$alerts;
  }
}
