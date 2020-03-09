<?php

function calCcs(){
    global $ccs, $wtcs, $nc, $ccspps;
    for ($i = 1; $i <= sizeof($ccs); $i++) {
        $ccs[$i] =  ($wtcs[$i] * $nc[$i]) + $ccspps[$i];
    }

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
    if ($ifFoundprev == true && $ifFoundthis == true){
        $ccspps[$linesno] += 3;
    }else{
        $ifFoundprev = $ifFoundthis;
    }
}

?>