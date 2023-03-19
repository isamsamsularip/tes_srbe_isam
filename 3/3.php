<?php
function find_two_numbers($numbers, $target) {
    $num_map = array();
    for ($i = 0; $i < count($numbers); $i++) {
        $complement = $target - $numbers[$i];
        if (array_key_exists($complement, $num_map)) {
            return array($num_map[$complement], $i);
        }
        $num_map[$numbers[$i]] = $i;
    }
    return null;
}
$numbers1 = array(0, 2, 0, 4, 5, 0);
$target1 = 5;
$result1 = find_two_numbers($numbers1, $target1);
print_r($result1); // Output: Array ( [0] => 2 [1] => 4 )

$numbers2 = array(2, 7, 11, 15);
$target2 = 9;
$result2 = find_two_numbers($numbers2, $target2);
print_r($result2); // Output: Array ( [0] => 0 [1] => 1 )
?>
