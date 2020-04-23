<?php

function calCcs()
{
    global $ccs, $wtcs, $nc, $ccspps, $colons;
    for ($i = 1; $i <= sizeof($ccs); $i++) {
        $ccs[$i] = ($wtcs[$i] * $nc[$i]) + $ccspps[$i];
    }

}

function findControlStructure($codes)
{
    global $brackets, $ifarray, $switcharray, $forarray, $casearray, $colons;

    $linesno = 1;
    $brackets = 0;
    $colons = 0;

    $ifarray = array_fill(0, sizeof($codes), 0);
    $switcharray = array_fill(0, sizeof($codes), 0);
    $forarray = array_fill(0, sizeof($codes), 0);
    $casearray = array_fill(0, sizeof($codes), 0);

    foreach ($codes as $lines) {
        bracketcount($lines, $linesno);
        calCcs();
        $linesno++;
    }
}

function bracketcount($lines, $linesno)
{
    global $brackets, $ifarray, $switcharray, $forarray;
    if (preg_match("/{/", $lines) > 0) {
        $brackets += 1;

    }
    if (preg_match("/}/", $lines) > 0) {

        $ifarray[$brackets] = 0;
        $switcharray[$brackets] = 0;
        $forarray[$brackets] = 0;
        $brackets -= 1;
    }

    if (preg_match("@//@", $lines) == 0) {
        checkIF($lines, $linesno, $brackets);
        checkSWITCH($lines, $linesno, $brackets);
        checkCASE($lines, $linesno, $brackets);
        checkFor($lines, $linesno, $brackets);
    }

}

function checkIF($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $ifarray, $casearray, $switcharray, $newccs, $colons;
    if (preg_match("/if/", $lines) > 0 || preg_match("/else if/", $lines) > 0) {
        print_r($casearray[$colons]);
        $andCount = (preg_match("/&&/", $lines));
        $nc[$linesno] += $andCount + 1;
        $wtcs[$linesno] += 2;

        $ifarray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

function checkSWITCH($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $switcharray;
    if (preg_match("/switch/", $lines) > 0) {
        $nc[$linesno]++;
        $wtcs[$linesno] += 2;
        $switcharray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$switcharray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

function checkCASE($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $switcharray, $colons, $casearray;
    if (preg_match("/case/", $lines) > 0) {
        $colons++;
        $nc[$linesno]++;
        $wtcs[$linesno] += 1;
        $casearray[$colons] = $linesno;

        if ($switcharray[$brackets] != 0) {
            $newccs = $ccs[$switcharray[$brackets]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

function checkFor($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $forarray, $colons;
    if (preg_match("/for/", $lines) > 0) {
        $nc[$linesno]++;
        $wtcs[$linesno] += 3;
        $forarray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }

    }
}