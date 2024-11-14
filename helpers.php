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
function loadView($name)
{
  $path = basePath("views/{$name}.view.php");
  if (file_exists($path)) {
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
function loadPartial($name)
{
  $path = basePath("views/partials/{$name}.php");
  if (file_exists($path)) {
    require $path;
  } else {
    echo "Partial '{$name}' not found! Please ensure the file exists at the specified path: '{$path}'.";
  }
}
