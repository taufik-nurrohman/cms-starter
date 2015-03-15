<?php include 'header.php'; ?>
<?php

echo '<p><strong>Page:</strong> ' . $offset . '</p>';

$per_page = 2;
$articles = glob('articles/*.txt');
rsort($articles);
$articles_chunk = array_chunk($articles, $per_page);

if(count($articles) > 0) {
    if(isset($articles_chunk[$offset - 1])) {
        // Create article list
        foreach($articles_chunk[$offset - 1] as $article) {
            $content = explode('<!-- cut -->', file_get_contents($article), 2);
            echo trim($content[0]);
            $path = explode('_', basename($article, '.txt'), 2);
            $path[0] = str_replace('-', '/', $path[0]);
            echo '<p><a href="' . $url_home . '/article/' . implode('/', $path) . '">Read More</a></p>';
            echo '<hr>';
        }
        // Create article pagination
        echo '<p>';
        if($offset > 1) {
            echo '<a href="' . $url_home . '/blog/' . ($offset - 1) . '">Previous</a>';
        } else {
            echo '<span>Previous</span>';
        }
        echo ' &middot; ';
        if($offset < ceil(count($articles) / $per_page)) {
            echo '<a href="' . $url_home . '/blog/' . ($offset + 1) . '">Next</a>';
        } else {
            echo '<span>Next</span>';
        }
        echo '</p>';
    } else {
        echo '<p>Not found.</p>';
    }
} else {
    echo '<p>No articles yet.</p>';
}

?>
<?php include 'footer.php'; ?>