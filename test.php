<?php

function test ($text, $n) {
    $newText = $text . $n;

    echo $newText . "\n";
//     return $newText;

    if ($n == 1) {
        echo $newText . '********' . "\n";
        echo 'Finish' . "\n";
        return $newText; // null

    } else {
        return test($newText, $n - 1);
    }
}

var_dump(test('bla', 3));

?>