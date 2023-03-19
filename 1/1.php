<?php

function groupAnagrams($words) {
    $anagrams = array();
    foreach ($words as $word) {
        $sorted_word = str_split($word);
        sort($sorted_word);
        $sorted_word = implode('', $sorted_word);
        $anagrams[$sorted_word][] = $word;
    }
    return array_values($anagrams);
}

$words = array("kita", "atik", "tika", "kau", "aku", "kua", "makan", "kia", "gameconsign");

$output = groupAnagrams($words);

echo json_encode($output);

?>
