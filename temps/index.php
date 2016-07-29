<?php

$var = '<script>alert(1);</script> <p>aaa</p> <p>bbbb</p>';
echo preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $var);

?>

