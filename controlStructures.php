<?php

function calCcs(){
    global $ccs, $wtcs, $nc, $ccspps;
    for ($i = 1; $i <= sizeof($ccs); $i++) {
        $ccs[$i] =  ($wtcs[$i] * $nc[$i]) + $ccspps[$i];
    }

}

function findForLoops($codes){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis,$ifFoundprev;

    $linesno = 1;
    $ifFoundthis = false;
    $ifFoundprev = false;

    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        foreach ($words as $word) {
            checkFor($word,$linesno);
            }
            nestedFor($linesno);

        $linesno++;
        }

    }
function checkFor($word,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis, $ifFoundprev;
    if($word == 'for'){
        $nc[$linesno]++;
        $wtcs[$linesno] += 3;
        $ifFoundthis = true;
    }
}
function nestedFor($linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis,$ifFoundprev;
    if ($ifFoundprev && $ifFoundthis){
        $ccspps[$linesno] += 3;

    }
    $ifFoundprev = $ifFoundthis;
    $ifFoundthis = false;
}
function checkIF($word,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis, $ifFoundprev;
    if($word == 'for'){
        $nc[$linesno]++;
        $wtcs[$linesno] += 3;
        $ifFoundthis = true;
    }
}
function nestedIF($linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis,$ifFoundprev;
    if ($ifFoundprev && $ifFoundthis){
        $ccspps[$linesno] += 3;

    }
    $ifFoundprev = $ifFoundthis;
    $ifFoundthis = false;
}

function checkSWITCH($word,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis, $ifFoundprev;
    if($word == 'for'){
        $nc[$linesno]++;
        $wtcs[$linesno] += 3;
        $ifFoundthis = true;
    }
}
function nestedSWITCH($linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifFoundthis,$ifFoundprev;
    if ($ifFoundprev && $ifFoundthis){
        $ccspps[$linesno] += 3;

    }
    $ifFoundprev = $ifFoundthis;
    $ifFoundthis = false;
}

