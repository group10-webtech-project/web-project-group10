<?php

test('sum', function () {
    function sum($a, $b) {
        return $a + $b;
    }

    $result = sum(1, 2);

    expect($result)->toBe(3);
});
