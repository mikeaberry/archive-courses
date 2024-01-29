<?php

$file = 'postgraduate/course.txt';

$links = file($file);

set_time_limit(0);
if ($links) {
  foreach ($links as $key => $link) {
    if ($link) {
      $urlParts = parse_url(trim($link));

      $path = trim($urlParts['path'], '/');

      if (!file_exists($path)) {
        mkdir($path, 0777, true);
      }

      $file =  $path . '/index.html';

      $content = file_get_contents(trim($link));

      // Fix the base  
      $old_base = '//www.st-andrews.ac.uk/subjects/archive/postgraduate/';
      $new_base = '//archive.st-andrews.ac.uk/courses/2023-2024/pg/';
      $content = str_replace($old_base, $new_base, $content);       
       
       // Fix header title.
       $current_header_title = '- Subjects -';
       $new_header_title = '- Courses archive -';
       $content = str_replace($current_header_title, $new_header_title, $content);
 
       // Fix page Title.
       $current_page_title = '<a href="/subjects/">Subjects</a>';
       $new_page_title = '<a href="/courses/">Courses archive</a>';
       $content = str_replace($current_page_title, $new_page_title, $content);

      // Add the green banner.
      $banner = '<body>
 <div class="text-banner success">
 <div class="container">
     <p>This page has been archived and is no longer updated. <a href="https://archive.st-andrews.ac.uk">Back to archive</a>.</p>
 </div>
 </div>';
      $content = str_replace('<body>', $banner, $content);


      // Fix images
      $assets_old = '/assets/';
      $assets_replace = 'https://www.st-andrews.ac.uk/assets/';
      $content = str_replace($assets_old, $assets_replace, $content);

      // Remove primary nav.
      $pg_prim_nav = '<li><a href="/subjects/entry/academic-entry-explained/">Academic entry explained</a></li><li><a href="/subjects/entry/">Entry requirements</a></li><li><a href="/subjects/non-degree-courses/">Non-degree courses</a></li><li><a href="https://www.st-andrews.ac.uk/subjects/entry/indicator">Qualification indicator</a></li><li><a href="/subjects/study-options/">Study options</a></li>';
      $content = str_replace($pg_prim_nav, '', $content);

      // Remove secondary nav.
      $ug_sec_nav = '<li><a href="/subjects/archive/undergraduate/">Undergraduate</a></li><li><a href="/subjects/archive/postgraduate/">Postgraduate</a></li>';
      $content = str_replace($ug_sec_nav, '', $content);

      // Fix landing page links.
      $remove_from_link = '/subjects/archive/postgraduate/';
      $replace_link = '';
      $content = str_replace($remove_from_link, $replace_link, $content);


      // Breadcrumbs.
      // Fix archive link.
     $bc_archive_target = '<li><a href="/subjects/archive/">Archive</a></li>';
     $bc_archive_replace = '<li><a href="../../index.html">2023-2024</a></li>';
     $content = str_replace($bc_archive_target, $bc_archive_replace, $content);     
     
     $bc_year_old = '<a href="../index.html">2023-2024</a>';
     $bc_year_fix = '<a href="https://archive.st-andrews.ac.uk/courses/2023-2024/">2023-2024</a>';
     $content = str_replace($bc_year_old, $bc_year_fix, $content);

      // Fix breadcrumb University link.
      $bc_uni_target = '<a href="/">University</a>';
      $bc_uni_replace = '<a href="/">University archive</a>';
      $content = str_replace($bc_uni_target, $bc_uni_replace, $content);

      // Change breadcrumb archive link to courses link and remove subjects.
      $bc_archive_target = '<li><a href="/subjects/">Subjects</a></li><li><a href="/subjects/archive/">Archive</a></li>';
      $bc_archive_replace = '<li><a href="/courses/">Courses</a></li><li><a href="/courses/2023-2024/">2023-2024</a></li>';
      $content = str_replace($bc_archive_target, $bc_archive_replace, $content);    

    // Fix Postgraduate link.
      $bc_pg_old = '<a href="">';
      $bc_pg_fix = '<a href="https://archive.st-andrews.ac.uk/courses/2023-2024/pg/index.html">';
      $content = str_replace($bc_pg_old, $bc_pg_fix, $content);
     
      $footer = '<li><a href="/subjects/ancient-history/" target="null">Ancient history</a></li>
      <li><a href="/subjects/arabic/" target="null">Arabic</a></li>
<li><a href="/subjects/archaeology/" target="null">Archaeology</a></li>';

//$footer = strip_tags($footer);

  //  $content = preg_replace('#<div class="col-sm-4">(.*?)</div>#', '', $content);
echo $content;
     $content = str_replace($footer, 'gone gone gone', $content);
     echo $content;


      file_put_contents($file, $content);
    } else {
      exit();
    }
  }
}
echo 'process complete';
