<?php

namespace Controllers;

use Model\Project;
use Model\Task;
use Model\User;

class SeedController
{
  public static function index()
  {
    $data = json_decode(file_get_contents(__DIR__ . './../data/data.json'), true);
    $users = [];


    Task::deleteTable();
    Project::deleteTable();
    User::deleteTable();

    User::createTable('user');
    Project::createTable('project');
    Task::createTable('task');

    foreach ($data as $row) {
      $user = new User();
      $user->name = $row['name'];
      $user->email = $row['email'];
      $user->password = $row['password'];
      $user->token = $row['token'];
      $user->confirmed = $row['confirmed'];
      $user->hashPassword();
      $users[] = $user;
    }

    $result = User::insertMany($users);

    if ($result) {
      echo json_encode([
        'success' => true,
        'message' => 'Seed Executed'
      ]);
    }
  }
}
