<?php

/**
 * 1. Get the list of courses from Screaming Frog (Steve) and copy into a text file. 
 *	Note - This will probably be in a CSV file, but I found using a text file easier although this could be investigated.
 *	When copying from csv to text file there will be a comma at the end of each line. These and any spaces need to be removed. Use find and replace.

 * 2. First use a sample of the courses list (2-3 links and create a test file e.g. test-ug).
 */

/**
 *3. ($file) - This variable should point to this test file for testing and the larger file when using the full list.
 */

$file = 'postgraduate/test-pg.txt';
//$file = 'undergraduate/test-ug.txt';

/**
 * 4. ($links) - This variable is set equal to the file($file). The PHP function file() takes each link and builds an array so we can loop over.
 */

$links = file($file);

/**
 * 5. (set_time_limit(0)) - This code takes a long time to run (I think this is due to the includes file that contains a number of string replace functions) so the time limit is set to zero to allow the code to keep going. Maybe investigate why it takes such a long time.
 */

set_time_limit(0);
/**
 * 6. Loop (foreach) - This function loops over the array. All the following code occurs inside the loop.
 */
// Check that there is a links array.
if ($links) {
  // If true, loop over the array od url's.
  foreach ($links as $key => $link) {
    // Check there is a value for each url.
    if ($link) {
      // We can use this function to separate the url's into parts.
      $urlParts = parse_url(trim($link));
      // The above function allows us to target the part we need. In this case the path.
      $path = trim($urlParts['path'], '/');
      // Here we create a folder structure match that of the url list.
      if (!file_exists($path)) {
        mkdir($path, 0777, true);
      }
      // We now add an index.html file to each of the folder.
      $file =  $path . '/index.html';
      // The following function gets the contents of each file.
      $content = file_get_contents(trim($link));
      // Here we add the include file that contains the str_replace functions to update the pages. Comment/uncomment as required.
      include 'includes/include-pg.php';
      // include 'includes/include-ug.php';
      // We can now write the contents of each file in turn to the appropriate file index.html file.
      file_put_contents($file, $content);
    } else {
      echo 'process complete';
    }
  }
} else {
  echo 'No files to loop over';
}

