<?php

function sum_strings($a, $b) {
    $result = '';

    $maxLength = max(strlen($a), strlen($b));
    $aRevers = strrev($a);
    $bRevers = strrev($b);
  
    $remain = 0;
    for ($i = 0; $i <= $maxLength; $i++){
        $aInt = isset($aRevers[$i]) ? (int)$aRevers[$i] : 0;
        $bInt = isset($bRevers[$i]) ? (int)$bRevers[$i] : 0;
        
        $sum = $aInt + $bInt + $remain;
        $value = $sum % 10;
        $remain = intdiv($sum, 10);
        
        $result .= $value;
    }

    return ltrim(strrev($result), '0');
}
