<?php

namespace App;
class Paginador{
    //
    public static function  paginate($page,$totalPagina){
        $current = $page;
        $last = $totalPagina;
        $delta = 2;
        $left = $current - $delta;
        $right = $current + $delta + 1;
        $range = [];
        $width_range=[];
        $l = null;

        for ($i=1;$i<= $last;$i++){
            if($i == 1 || $i== $last || $i >= $left && $i < $right){
                array_push($range,$i);
            }
        }
        foreach ($range as $item) {
            if($l){
                if($item - $l === 2){
                    array_push($width_range,$l +1);
                }else if ($item - $l !== 1){
                    array_push($width_range,"...");
                }
            }
            array_push($width_range,$item);
            $l = $item;
        }
        return $width_range;
    }
}
