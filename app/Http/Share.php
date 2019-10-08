<?php
function priceToString($price){
    $strPrice = [];
    $result = [];
    array_push($result, ' ₫');
    $strPrice = str_split($price);
    $count=1;
    $l = count($strPrice);
    for($i=$l-1; $i>=0; $i--){
        array_push($result, $strPrice[$i]);
        if($count%3==0) {
            array_push($result, ',');
        }
        $count++;
    }
    return implode(array_reverse($result));
}
