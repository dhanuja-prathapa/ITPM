<?php

function calCcs(){



}

function findForLoops($codes){
    global $ccs,$wtcs,$nc,$ccspps;

    $linesno = 1;
    $ifFoundthis = false;
    $ifFoundprev = false;
    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        foreach ($words as $word) {
            checkFor($word,$linesno);
            }
            nestedIf($linesno);

        $linesno++;
        }
    }
function checkFor($word,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis;
    if($word == 'for'){
        $nc[$linesno]++;
        $wtcs[$linesno] += 3; 
        $ifFoundthis = true;
    }else{
        $ifFoundthis = false;
    }
}
function nestedIf($linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis,$ifFoundprev;
    if ($ifFoundprev && $ifFoundthis){
        $ccspps[$linesno] += 3;
    }else{
        $ifFoundprev = $ifFoundthis;
    }
}
