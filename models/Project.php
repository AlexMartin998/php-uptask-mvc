<?php

namespace Project;

use Model\ActiveRecord;

class Project extends ActiveRecord
{
  protected static $table = 'users';
  protected static $dbColumns = ['id', 'title', 'url', 'owner_id'];

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->title = $args['title'] ?? '';
    $this->url = $args['url'] ?? '';
    $this->owner_id = $args['owner_id'] ?? '';
  }
}
