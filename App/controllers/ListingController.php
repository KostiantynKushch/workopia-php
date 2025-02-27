<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingController
{

  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /**
   * Show all listings
   *
   * @return void
   */
  public function index()
  {
    $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();

    loadView('listings/index', [
      'listings' => $listings,
    ]);
  }

  /**
   * Show listings create form
   *
   * @return void
   */
  public function create()
  {
    loadView('listings/create');
  }

  /**
   * Show single listing
   *
   * @param array $params
   * @return void
   */
  public function show($params)
  {
    $id = $params['id'] ?? '';

    $params = [
      'id' => $id,
    ];

    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing is not found');
      return;
    }

    loadView('listings/show', [
      'listing' => $listing,
    ]);
  }

  /**
   * Store data in database
   *
   * @return void
   */
  public function store()
  {
    $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

    $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
    $newListingData['user_id'] = 1;
    $newListingData = array_map('sanitize', $newListingData);

    $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      }
    }

    if (!empty($errors)) {
      // Reload view with errors
      loadView('listings/create', [
        'errors' => $errors,
        'fields' => $newListingData,
      ]);
    } else {
      // Submit data
      $postData = Database::fieldsAndValues($newListingData);

      $query = 'INSERT INTO listings ' . $postData;

      $this->db->query($query, $newListingData);

      redirect('/listings');
    }
  }

  /**
   * Delete a listing
   *
   * @param array $params
   * @return void
   */
  public function destroy($params)
  {
    $params = [
      'id' => $params['id'],
    ];

    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing not found');
      return;
    }

    $this->db->query('DELETE FROM listings WHERE id = :id', $params);

    // Set flash message
    $_SESSION['success_message'] = 'Listing deleted successfully';

    redirect('/listings');
  }

  /**
   * Edit single listing
   *
   * @param array $params
   * @return void
   */
  public function edit($params)
  {
    $id = $params['id'] ?? '';

    $params = [
      'id' => $id,
    ];

    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing is not found');
      return;
    }

    loadView('listings/edit', [
      'fields' => $listing,
    ]);
  }

  /**
   * Update single listing
   *
   * @param array $params
   * @return void
   */
  public function update($params)
  {
    $id = $params['id'] ?? '';

    $params = [
      'id' => $id,
    ];

    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing is not found');
      return;
    }

    $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

    $updateValues = array_intersect_key($_POST, array_flip($allowedFields));
    $updateValues = array_map('sanitize', $updateValues);

    $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      }
    }

    if (!empty($errors)) {
      // Reload view with errors
      loadView('listings/edit', [
        'errors' => $errors,
        'fields' => $listing,
      ]);
      exit;
    } else {
      // Submit to the database
      $updateFields = [];

      foreach (array_keys($updateValues) as $field) {
        $updateFields[] = "{$field} = :{$field}";
      }

      $updateFields = implode(', ', $updateFields);

      $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";

      $updateValues['id'] = $id;

      $this->db->query($updateQuery, $updateValues);

      $_SESSION['success_message'] = 'Listing Updated';

      redirect('/listings/' . $id);
    }
  }
}
