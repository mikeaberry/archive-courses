<?php

$file = 'undergraduate/ug-courses.txt';

$links = file($file);


set_time_limit(0);

foreach ($links as $key => $link) {
    if ($link) {

        $urlParts = parse_url(trim($link));

        $path = trim($urlParts['path'], '/');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file =  $path . '/index.html';

        $content = file_get_contents(trim($link));

        // Add green banner.
        $banner = '<body>
 <div class="text-banner success">
 <div class="container">
     <p>This page has been archived and is no longer updated. <a href="https://archive.st-andrews.ac.uk">Back to archive</a>.</p>
 </div>
 </div>';
        $content = str_replace('<body>', $banner, $content);
        // Fix header title.
        $current_header_title = '- Subjects -';
        $new_header_title = '- Courses archive -';
        $content = str_replace($current_header_title, $new_header_title, $content);
        // Fix page Title.
        $current_page_title = '<a href="/subjects/">Subjects</a>';
        $new_page_title = '<a href="/courses/">Courses archive</a>';
        $content = str_replace($current_page_title, $new_page_title, $content);
        // Change the site base path.
        $base_old = 'www.st-andrews.ac.uk/subjects/archive/undergraduate/2023-entry/';
        $base_new = 'archive.st-andrews.ac.uk/courses/2023-2024/ug/';
        $content = str_replace($base_old, $base_new, $content);
        // Fix links to pages on ug page.
        $remove_from_link = '/subjects/archive/undergraduate/2023-entry/';
        $replace_link = '/courses/2023-2024/ug/';
        $content = str_replace($remove_from_link, $replace_link, $content);

        //Breadcrumbs.

        // Fix breadcrumb University link.
        $bc_uni_target = '<a href="/">University</a>';
        $bc_uni_replace = '<a href="/">University archive</a>';
        $content = str_replace($bc_uni_target, $bc_uni_replace, $content);

        // Fix archive link.
        $bc_archive_target = '<li><a href="/subjects/archive/">Archive</a></li>';
        $bc_archive_replace = '<li><a href="../../index.html">2023-2024</a></li>';
        $content = str_replace($bc_archive_target, $bc_archive_replace, $content);

        $bc_year_old = '<a href="../index.html">2023-2024</a>';
        $bc_year_fix = '<a href="https://archive.st-andrews.ac.uk/courses/2023-2024/">2023-2024</a>';
        $content = str_replace($bc_year_old, $bc_year_fix, $content);

        // Fix breadcrumb University link.
        $bc_uni_target = '<li><a href="/">University</a></li>';
        $bc_uni_replace = '<li><a href="/">University Archive</a></li>';
        $content = str_replace($bc_uni_target, $bc_uni_replace, $content);
        // Change breadcrumb archive link to courses link and remove subjects.
        $bc_archive_target = '<li><a href="/subjects/">Subjects</a></li><li><a href="/subjects/archive/">Archive</a></li>';
        $bc_archive_replace = '<li><a href="/courses/">Courses</a></li><li><a href="/courses/2023-2024/">2023-2024</a></li>';
        $content = str_replace($bc_archive_target, $bc_archive_replace, $content);
        // Fix breadcrumb year link.
        $bc_year_old = '<a href="../index.html">2023-2024</a>';
        $bc_year_fix = '<a href="https://archive.st-andrews.ac.uk/courses/2023-2024/">2023-2024</a>';
        $content = str_replace($bc_year_old, $bc_year_fix, $content);
        // Fix breadcrumb pg link.
        $bc_pg_old = '<a href="">';
        $bc_pg_fix = '<a href="https://archive.st-andrews.ac.uk/courses/2023-2024/ug/index.html">';
        $content = str_replace($bc_pg_old, $bc_pg_fix, $content);
        // Fix breadcrumb ug link.
        $bc_ug_old = '<li><a href="/subjects/archive/undergraduate/">Undergraduate</a></li><li>2023 entry</li>';
        $bc_ug_fix = '<li>Undergraduate</li>';
        $content = str_replace($bc_ug_old, $bc_ug_fix, $content);
        // Remove entry folder from breadcrumbs
        $bc_entry_old = '<li><a href="/subjects/archive/undergraduate/">Undergraduate</a></li><li><a href="/courses/2023-2024/ug/">2023 entry</a></li>';
        $bc_entry_fix = '<li><a href="/courses/2023-2024/ug/">Undergraduate</a></li>';
        $content = str_replace($bc_entry_old, $bc_entry_fix, $content);
        // Fix images
        $assets_old = '/assets/';
        $assets_replace = 'https://www.st-andrews.ac.uk/assets/';
        $content = str_replace($assets_old, $assets_replace, $content);
        //Remove secondary nav
        $ug_secondary_nav = '<nav class="navigation-bar subnav" aria-label="Secondary menu"><div class="container"><div class="toggle-navigation secondary-toggle"><button class="navigation-button" aria-expanded="false" aria-controls="secondary-nav">Section navigation <i class="chevron down"></i></button></div><ul class="navigation-bar-nav secondary-nav" id="secondary-nav"><li><a href="/courses/2023-2024/ug/">Undergraduate</a></li><li><a href="/courses/2023-2024/pg/">Postgraduate</a></li></ul></div></nav>';
        $ug_secondary_nav2 = '<nav class="navigation-bar subnav" aria-label="Secondary menu">
        <div class="container">
            <div class="toggle-navigation secondary-toggle"><button class="navigation-button" aria-expanded="false" aria-controls="secondary-nav">Section navigation <i class="chevron down"></i></button></div>
            <ul class="navigation-bar-nav secondary-nav" id="secondary-nav"><li><a href="/courses/2023-2024/ug/">Undergraduate</a></li><li><a href="/courses/2023-2024/pg/">Postgraduate</a></li>		</ul>
        </div>
    </nav>';
        $ug_nav_remove = '';
        $ug_sec_nav = '<li><a href="/subjects/archive/undergraduate/">Undergraduate</a></li><li><a href="/subjects/archive/postgraduate/">Postgraduate</a></li>';
        //$content = str_replace($ug_secondary_nav2, 'Mike is here', $content);
        $content = str_replace($ug_sec_nav, '', $content);
        //$content = preg_replace('#<nav class="navigation-bar subnav" aria-label="Secondary menu">(.*?)</nav>#', '', $content);

        $ug_prim_nav = '<li><a href="/subjects/entry/academic-entry-explained/">Academic entry explained</a></li><li><a href="/subjects/entry/">Entry requirements</a></li><li><a href="/subjects/non-degree-courses/">Non-degree courses</a></li><li><a href="https://www.st-andrews.ac.uk/subjects/entry/indicator">Qualification indicator</a></li><li><a href="/subjects/study-options/">Study options</a></li>';
        $content = str_replace($ug_prim_nav, '', $content);        

        // Add content to index.html within the folders.
        $header = '<a href="https://www.st-andrews.ac.uk/" aria-label="University of St Andrews"><span>University of St&nbsp;Andrews</span></a>';

    $header = str_replace('&nbsp;', '', $header);
   
        $content = str_replace($header, '', $content);

       

        $content = preg_replace('#<div id="logo-container">(.*?)</div>#', '', $content);




        file_put_contents($file, $content);
    } else {
        exit();
    }
}

echo 'process complete';
