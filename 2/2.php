<?php
$num = 5;

// Generate the pattern
for ($i = 1; $i <= $num; $i++) {
    for ($j = 1; $j <= $num; $j++) {
        if ($i == ($num + 1) / 2 && $j == ($num + 1) / 2) {
            echo "#";
        } else if (abs($i - ($num + 1) / 2) + abs($j - ($num + 1) / 2) <= ($num - 1) / 2) {
            echo "#";
        } else {
            echo "*";
        }
    }
    echo "\n";
}
?>
