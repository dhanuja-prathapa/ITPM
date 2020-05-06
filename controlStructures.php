<!-- K S S Bandaranayake part -->
<?php

//Main function to find components of control structures
function findControlStructure($codes)
{
    //Declare the global variables
    global $brackets, $ifarray, $switcharray, $forarray, $casearray, $colons, $whilearray;

    //Initialize relevant variables
    $linesno = 1;
    $brackets = 0;
    $colons = 0;

    //Declare as array having 0 as initial value
    $ifarray = array_fill(0, sizeof($codes), 0);
    $switcharray = array_fill(0, sizeof($codes), 0);
    $forarray = array_fill(0, sizeof($codes), 0);
    $casearray = array_fill(0, sizeof($codes), 0);
    $whilearray = array_fill(0, sizeof($codes), 0);

    //Loop checking each code line for control structure components
    foreach ($codes as $lines) {
        bracketcount($lines, $linesno);//No of brackets consideration and keeping track function called
        calCcs();//call for calculating final Ccs value needed for table
        $linesno++;
    }
}

function bracketcount($lines, $linesno)
{
    global $brackets, $ifarray, $switcharray, $forarray, $casearray, $colons, $whilearray;

    //Finds when a bracket starts
    if (preg_match("/{/", $lines) > 0) {
        $brackets += 1;

    }
    //Finds when a bracket ends
    if (preg_match("/}/", $lines) > 0) {

        //Declare relevant array variables to 0
        $ifarray[$brackets] = 0;
        $switcharray[$brackets] = 0;
        $forarray[$brackets] = 0;
        $whilearray[$brackets] = 0;
        $brackets -= 1;
    }
    //Proceeding further after checking if the line is not a comment
    if (preg_match("@//@", $lines) == 0) {
        checkIF($lines, $linesno, $brackets);//Checking 'if' or 'else-if' function called
        checkSWITCH($lines, $linesno, $brackets);//Checking 'switch' function called
        checkCASE($lines, $linesno, $brackets);//Checking 'case' function called
        checkFor($lines, $linesno, $brackets);//Checking 'for' function called
        checkWhile($lines, $linesno, $brackets);//Checking 'while' or 'do while' loop function called
    }
}

//If component finding function
function checkIF($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $ifarray, $casearray, $switcharray, $newccs, $colons, $forarray, $whilearray, $wif;

    //Checking for if or else if in line
    if (preg_match("/if/", $lines) > 0 || preg_match("/else if/", $lines) > 0) {

        //Considering multiple if condition is present or not in one line along with '&&'
        $andCount = (preg_match("/&&/", $lines));
        $nc[$linesno] += $andCount + 1;//adding nc count considering the '&&'
        $wtcs[$linesno] += $wif; //assign the wtcs value by the manual given or default weight

        //looking for nested if present with help of the brackets array
        $ifarray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        //check for if inside another if
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //check for if inside a switch case
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
        //check for if inside a for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //check for of inside while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

function checkSWITCH($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $switcharray, $ifarray, $newccs, $whilearray, $forarray,$wswt ;
    if (preg_match("/switch/", $lines) > 0) {
        $nc[$linesno]++;
        $wtcs[$linesno] += $wswt;
        $switcharray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$switcharray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

function checkCASE($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $switcharray, $colons, $casearray, $wcase;
    if (preg_match("/case/", $lines) > 0) {
        $colons++;
        $nc[$linesno]++;
        $wtcs[$linesno] += $wcase;
        $casearray[$colons] = $linesno;

        if ($switcharray[$brackets] != 0) {
            $newccs = $ccs[$switcharray[$brackets]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

function checkFor($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $forarray, $colons, $switcharray, $casearray, $newccs, $ifarray, $whilearray, $wfw;
    if (preg_match("/for/", $lines) > 0) {
        $nc[$linesno]++;
        $wtcs[$linesno] += $wfw;
        $forarray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

function checkWhile($lines, $linesno, $brackets)
{
    global $ccs, $wtcs, $nc, $ccspps, $forarray, $colons, $switcharray, $casearray, $newccs, $ifarray, $whilearray, $wfw;
    if (preg_match("/while/", $lines) > 0) {
        $nc[$linesno]++;
        $wtcs[$linesno] += $wfw;
        $whilearray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

//Calculating the final Ccs value function
function calCcs()
{
    global $ccs, $wtcs, $nc, $ccspps;
    for ($i = 1; $i <= sizeof($ccs); $i++) {
        $ccs[$i] = ($wtcs[$i] * $nc[$i]) + $ccspps[$i];
    }

}