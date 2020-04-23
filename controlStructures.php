<?php

function calCcs(){
    global $ccs, $wtcs, $nc, $ccspps;
    for ($i = 1; $i <= sizeof($ccs); $i++) {
        $ccs[$i] =  ($wtcs[$i] * $nc[$i]) + $ccspps[$i];
    }

}

function findControlStructure($codes){
    global $ccs,$wtcs,$nc,$ccspps,$ifthis,$ifprev,$forthis,$forprev,$switchprev,$switchthis,$brackets, $ifarray;

    $linesno = 1;
    $ifthis = false;
    $ifprev = false;
    $forthis = false;
    $forprev = false;
    $switchthis = false;
    $switchprev= false;
    $brackets = 0;
    $ifarray = array_fill(0,sizeof($codes),0);

    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        bracketcount($lines,$linesno);
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


function bracketcount($lines,$linesno){
    global $ccs,$wtcs,$nc,$ccspps,$ifthis,$ifprev,$forthis,$forprev,$switchprev,$switchthis,$brackets, $ifarray;
    if(preg_match("/{/",$lines)>0){
        $brackets += 1;

    }
    if(preg_match("/}/",$lines)>0){

        $ifarray[$brackets] = 0;
        $brackets -= 1;
    }
    checkIF($lines,$linesno,$brackets);

}

function checkIF($lines,$linesno,$brackets){
    global $ccs,$wtcs,$nc,$ccspps,$ifthis, $ifprev, $ifarray;
    if(preg_match("/if/",$lines)> 0){
        $nc[$linesno]++;
        $wtcs[$linesno] += 2;
        $ifarray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }

    }
}