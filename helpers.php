<?php

/**
 * Get the base pathinfo
 * 
 * @param string $path
 * @return string
 */
function basePath($path = '')
{
  return __DIR__ . '/' . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function loadView($name, $data = [])
{
  $path = basePath("App/views/{$name}.view.php");
  if (file_exists($path)) {
    extract($data);
    require $path;
  } else {
    echo "View '{$name}' not found! Please ensure the file exists at the specified path: '{$path}'.";
  }
}

/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name, $data = [])
{
  $path = basePath("App/views/partials/{$name}.php");
  if (file_exists($path)) {
    extract($data);
    require $path;
  } else {
    echo "Partial '{$name}' not found! Please ensure the file exists at the specified path: '{$path}'.";
  }
}

/**
 * Inspect variable
 * @param mixed $value
 * @return void
 */
function inspect($value)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
}

/**
 * Inspect variable and die
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value)
{
  inspect($value);
  die();
}


/**
 * Format salary
 * 
 * @param string $salary
 * @return string Formatted salary
 */
function formatSalary($salary)
{
  return '$' . number_format(floatval($salary));
}

/**
 * Sanitize data
 *
 * @param string $data
 * @return string
 */
function sanitize($data)
{
  return filter_var(trim($data), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to a given urldecode
 *
 * @param string $url
 * @return void
 */
function redirect($url)
{
  header("Location: {$url}");
  exit;
}
