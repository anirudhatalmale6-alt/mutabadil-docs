<?php
$funcFile = '/data/4/0/40b4caae-3ac8-469c-97dd-38325e95a8fc/mutabadil.com/web/wp-content/themes/publisher/functions.php';
$f = file_get_contents($funcFile);

$snippet = <<<'PHPCODE'

// Nastaleeq Font + RTL
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("google-nastaleeq", "https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&family=Gulzar&display=swap", array(), null);
    wp_enqueue_style("custom-nastaleeq", get_template_directory_uri() . "/custom-nastaleeq.css", array("google-nastaleeq"), "1.0");
}, 999);
PHPCODE;

$f .= $snippet;
file_put_contents($funcFile, $f);
echo "functions.php updated with Nastaleeq fonts\n";
