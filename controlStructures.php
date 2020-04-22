<?php

function calCcs(){
    global $ccs, $wtcs, $nc, $ccspps;
    for ($i = 1; $i <= sizeof($ccs); $i++) {
        $ccs[$i] =  ($wtcs[$i] * $nc[$i]) + $ccspps[$i];
    }

}

function findControlStructure($codes){
    global $ccs,$wtcs,$nc,$ccspps,$ifthis,$ifprev,$forthis,$forprev,$switchprev,$switchthis;

    $linesno = 1;
    $ifthis = false;
    $ifprev = false;
    $forthis = false;
    $forprev = false;
    $switchthis = false;
    $switchprev= false;

    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        foreach ($words as $word) {
            checkFor($word,$linesno);
            checkIF($word,$linesno);
            checkSWITCH($word,$linesno);
            calCcs();
            }
            nestedFor($linesno);
            nestedIF($linesno);
            calCcs();

        $linesno++;
        }

    }
function checkFor($word,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$forthis, $forprev;
    if(preg_match("/for/",$word)> 0){
        $nc[$linesno]++;
        $wtcs[$linesno] += 3;
        $forthis = true;
    }
}
function nestedFor($linesno){
    global $ccs,$wtcs,$nc,$ccspps,$forthis,$forprev;
    if ($forprev && $forthis){
        $prevline = $linesno -1;
        $newccs = $ccs[$prevline];
        $ccspps[$linesno] += $newccs;

    }
    $forprev = $forthis;
    $forthis = false;
}
function checkIF($word,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifthis, $ifprev;
    if(preg_match("/if/",$word)> 0){
        $nc[$linesno]++;
        $wtcs[$linesno] += 2;
        $ifthis = true;
    }
}
function nestedIF($linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifthis,$ifprev;
    if ($ifprev && $ifthis){
        $prevline = $linesno -1;
        $newccs = $ccs[$prevline];
        $ccspps[$linesno] += $newccs;

    }
    $ifprev = $ifthis;
    $ifthis = false;
}

function checkSWITCH($word,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$switchthis, $switchprev;
    if(preg_match("/switch/",$word)> 0){
        $nc[$linesno]++;
        $wtcs[$linesno] += 2;
        $switchthis = true;
        $prevline = $linesno -1;
        if($ccs[$prevline] != 0){
            $ccspps[$linesno] += $ccs[$prevline];
        }
    }
}
function nestedSWITCH($linesno){
    global $ccs,$wtcs,$nc,$ccspps,$switchthis,$switchprev;
    if ($switchprev && $switchthis){
        $prevline = $linesno -1;
        $newccs = $ccs[$prevline];
        $ccspps[$linesno] += $newccs;

    }
    $switchprev = $switchthis;
    $switchthis = false;
}

