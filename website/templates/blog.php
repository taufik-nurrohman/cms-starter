<?php include 'header.php'; ?>
<?php

echo '<p><strong>Offset:</strong> ' . $offset . '</p>';
echo '<p>';
echo $offset > 1 ? '<a href="' . $host . '/blog/' . ($offset - 1) . '">Previous</a> ' : "";
echo '<a href="' . $host . '/blog/' . ($offset + 1) . '">Next</a>';
echo '</p>';

?>
<?php include 'footer.php'; ?>