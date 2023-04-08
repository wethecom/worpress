<?php
// Load WordPress environment
require_once('./wp-load.php');

// Get a random post
$args = array(
    'post_type' => 'post',
    'orderby' => 'rand',
    'posts_per_page' => 1
);
$random_post = new WP_Query($args);

// Output RSS feed
header("Content-Type: application/rss+xml; charset=utf-8");
echo "<?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
  <title>Random WordPress Post</title>
  <link>" . get_bloginfo('url') . "</link>
  <description>A random post from WordPress</description>";

if ($random_post->have_posts()) {
    while ($random_post->have_posts()) {
        $random_post->the_post();
        echo "<item>";
        echo "<title>" . get_the_title() . "</title>";
        echo "<link>" . get_permalink() . "</link>";
        echo "<pubDate>" . get_the_date('r') . "</pubDate>";
        echo "<description><![CDATA[" . get_the_excerpt() . "]]></description>";
        echo "</item>";
    }
} else {
    echo "<item><title>No posts found</title></item>";
}

echo "</channel>
</rss>";
