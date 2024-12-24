<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class UserController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /**
   * Show the login page
   *
   * @return void
   */
  public function login()
  {
    loadView('users/login');
  }

  /**
   * Show the register page
   *
   * @return void
   */
  public function create()
  {
    loadView('users/create');
  }

  /**
   * Store a user in the database
   *
   * @return void
   */
  public function store()
  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];

    $errors = [];

    // Validation
    if (!Validation::email($email)) {
      $errors['email'] = 'Please enter a valid email address';
    }

    if (!Validation::string($name, 2, 50)) {
      $errors['name'] = 'Name must be between 2 and 50 characters';
    }

    if (!Validation::string($password, 6, 50)) {
      $errors['password'] = 'Password must be between 6 and 50 characters';
    }

    if (!Validation::match($password, $passwordConfirmation)) {
      $errors['password_confirmation'] = 'Passwords do not match';
    }

    // Check if email already exist
    $params = [
      'email' => $email,
    ];

    if (!isset($errors['email'])) {
      $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();
      if ($user) {
        $errors['email_exist'] = 'Can\'t create user with this email';
      }
    }

    if (!empty($errors)) {
      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name,
          'email' => $email,
          'city' => $city,
          'state' => $state,
        ]
      ]);
      exit;
    }

    // Create user account
    $params = [
      'name' => $name,
      'email' => $email,
      'city' => $city,
      'state' => $state,
      'password' => password_hash($password, PASSWORD_DEFAULT),
    ];

    $userData = Database::fieldsAndValues($params);

    $this->db->query("INSERT INTO users {$userData}", $params);

    redirect('/');
  }
}
