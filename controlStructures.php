<!-- K S S Bandaranayake part -->
<?php

//Main function to find components of control structures
function findControlStructure($codes)
{
    //Declare the global variables
    global $brackets, $ifarray, $switcharray, $forarray, $casearray, $colons, $whilearray, $dowhilearray;

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
    $dowhilearray = array_fill(0, sizeof($codes), 0);

    //Loop checking each code line for control structure components
    foreach ($codes as $lines) {
        bracketcount($lines, $linesno);//No of brackets consideration and keeping track function called
        calCcs();//call for calculating final Ccs value needed for table
        $linesno++;
    }
}

function bracketcount($lines, $linesno)
{
    global $brackets, $ifarray, $switcharray, $forarray, $whilearray, $dowhilearray;

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
        $dowhilearray[$brackets] = 0;
        $brackets -= 1;
    }
    //Checking if the line has comment but also a control structure and proceeding
    if (preg_match("@//@", $lines) != 0) {

        if ((strpos($lines, 'if (') !== false)) {
            checkIF($lines, $linesno, $brackets);//Checking 'if' or 'else-if' function called
        }
        if ((strpos($lines, 'if(') !== false)) {
            checkIF($lines, $linesno, $brackets);//Checking 'if' or 'else-if' function called
        }
        if ((strpos($lines, 'switch (') !== false)) {
            checkSWITCH($lines, $linesno, $brackets);//Checking 'switch' function called
        }
        if ((strpos($lines, 'switch(') !== false)) {
            checkSWITCH($lines, $linesno, $brackets);//Checking 'switch' function called
        }
        if ((strpos($lines, ':') !== false)) {
            checkCASE($lines, $linesno, $brackets);//Checking 'case' function called
        }
        if ((strpos($lines, 'for (') !== false)) {
            checkFor($lines, $linesno, $brackets);//Checking 'for' function called
        }
        if ((strpos($lines, 'for(') !== false)) {
            checkFor($lines, $linesno, $brackets);//Checking 'for' function called
        }
        if ((strpos($lines, 'while (') !== false)) {
            checkWhile($lines, $linesno, $brackets);//Checking 'while' loop function called
        }
        if ((strpos($lines, 'while(') !== false)) {
            checkWhile($lines, $linesno, $brackets);//Checking 'while' loop function called
        }
        if ((strpos($lines, 'do {') !== false)) {
            checkDoWhile($lines, $linesno, $brackets);//Checking  'do while' loop function called
        }
        if ((strpos($lines, 'do{') !== false)) {
            checkDoWhile($lines, $linesno, $brackets);//Checking  'do while' loop function called
        }
    } //Proceeding further after checking if the line is not a comment
    else {
        checkIF($lines, $linesno, $brackets);//Checking 'if' or 'else-if' function called
        checkSWITCH($lines, $linesno, $brackets);//Checking 'switch' function called
        checkCASE($lines, $linesno, $brackets);//Checking 'case' function called
        checkFor($lines, $linesno, $brackets);//Checking 'for' function called
        checkWhile($lines, $linesno, $brackets);//Checking 'while' loop function called
        checkDoWhile($lines, $linesno, $brackets);//Checking 'while' loop function called
    }
}

//If component finding function
function checkIF($lines, $linesno, $brackets)
{
    //global variable declaration
    global $ccs, $wtcs, $nc, $ccspps, $ifarray, $casearray, $switcharray, $newccs, $colons, $forarray, $whilearray, $wif, $dowhilearray;

    //Checking for if or else if in line with space before bracket
    if ((strpos($lines, 'if (') !== false)) {

        //Considering multiple if condition is present or not in one line along with '&&'
        $andCount = (preg_match_all("/&&/", $lines));
        $nc[$linesno] += $andCount + 1;//adding nc count considering the '&&'
        $wtcs[$linesno] += $wif; //assign the wtcs value by the manual given or default weight

        //looking for nested if present with help of the brackets array
        $ifarray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        //check for if inside another if
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;//assigning previous if ccs to ccspps
        }
        //check for if inside a switch case
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;//assigning previous switch/case ccs ccspps
        }
        //check for if inside a for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;//assigning previous for loop ccs to ccspps
        }
        //check for if inside while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;//assigning previous while loop ccs to ccspps
        }
        //Check for if inside do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
    //Checking for if or else if in line without space before bracket
    if ((strpos($lines, 'if(') !== false)) {

        //Considering multiple if condition is present or not in one line along with '&&'
        $andCount = (preg_match_all("/&&/", $lines));
        $nc[$linesno] += $andCount + 1;//adding nc count considering the '&&'
        $wtcs[$linesno] += $wif; //assign the wtcs value by the manual given or default weight

        //looking for nested if present with help of the brackets array
        $ifarray[$brackets] = $linesno;
        $prevbracket = $brackets - 1;

        //check for if inside another if
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;//assigning previous if ccs to ccspps
        }
        //check for if inside a switch case
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;//assigning previous switch/case ccs ccspps
        }
        //check for if inside a for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;//assigning previous for loop ccs to ccspps
        }
        //check for if inside while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;//assigning previous while loop ccs to ccspps
        }
        //Check for if inside do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

//Switch component finding function
function checkSWITCH($lines, $linesno, $brackets)
{
    //global variable declaration
    global $ccs, $wtcs, $nc, $ccspps, $switcharray, $ifarray, $newccs, $whilearray, $forarray, $wswt, $casearray, $colons, $dowhilearray;

    //Checking for switch in line with space before bracket
    if ((strpos($lines, 'switch (') !== false)) {
        $nc[$linesno]++;//add nc
        $wtcs[$linesno] += $wswt;//assign weight taken manually
        $switcharray[$brackets] = $linesno;//storing inside switch array the particular line with bracket
        $prevbracket = $brackets - 1;

        //checking nested switch inside another switch case statement
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;;
        }
        //checking nested switch inside if
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //checking nested switch inside while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //checking nested switch inside for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested switch inside a do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }

    //Checking for switch in line without space before bracket
    if ((strpos($lines, 'switch(') !== false)) {
        $nc[$linesno]++;//add nc
        $wtcs[$linesno] += $wswt;//assign weight taken manually
        $switcharray[$brackets] = $linesno;//storing inside switch array the particular line with bracket
        $prevbracket = $brackets - 1;

        //checking nested switch inside another switch case statement
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;;
        }
        //checking nested switch inside if
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //checking nested switch inside while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //checking nested switch inside for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested switch inside a do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

//Case component finding function
function checkCASE($lines, $linesno, $brackets)
{
    //global variable declaration
    global $ccs, $wtcs, $nc, $ccspps, $switcharray, $colons, $casearray, $wcase;

    //Checking for 'case' in line
    if (preg_match("/case/", $lines) > 0) {
        if (preg_match("/:/", $lines) > 0) {
            $colons++;
            $nc[$linesno]++;
            $wtcs[$linesno] += $wcase;
            $casearray[$colons] = $linesno;

            //Checking for the ccs value of the switch it belongs to and assigning it to ccspps
            if ($switcharray[$brackets] != 0) {
                $newccs = $ccs[$switcharray[$brackets]];
                $ccspps[$linesno] += $newccs;
            }
        } else {
            //Do nothing
        }
    }
}

//For component finding function
function checkFor($lines, $linesno, $brackets)
{

    //global variable declaration
    global $ccs, $wtcs, $nc, $ccspps, $forarray, $colons, $switcharray, $casearray, $newccs, $ifarray, $whilearray, $wfw, $dowhilearray;

    //Checking 'for' in line with space from bracket
    if ((strpos($lines, 'for (') !== false)) {
        $nc[$linesno]++;//add nc
        $wtcs[$linesno] += $wfw;//assign 'for' weight to wtcs
        $forarray[$brackets] = $linesno;//saving particular bracket location inside forarray
        $prevbracket = $brackets - 1;

        //Check for nested for loop inside another for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside a switch
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside an if statement
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }

    //Checking 'for' in line without space from bracket
    if ((strpos($lines, 'for(') !== false)) {
        $nc[$linesno]++;//add nc
        $wtcs[$linesno] += $wfw;//assign 'for' weight to wtcs
        $forarray[$brackets] = $linesno;//saving particular bracket location inside forarray
        $prevbracket = $brackets - 1;

        //Check for nested for loop inside another for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside a switch
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside an if statement
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for nested for loop inside do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
    }
}

//While component finding function
function checkWhile($lines, $linesno, $brackets)
{

    //global variable declaration
    global $ccs, $wtcs, $nc, $ccspps, $forarray, $colons, $switcharray, $casearray, $newccs, $ifarray, $whilearray, $wfw, $dowhilearray;

    //Checking 'while' in line with space for bracket
    if ((strpos($lines, 'while (') !== false)) {
        if (strpos($lines, ');') !== false) {
            //Do nothing
        } else {
            $nc[$linesno]++;//add nc
            $wtcs[$linesno] += $wfw;//assign wtcs with weight given for while loop
            $whilearray[$brackets] = $linesno;//Save particular bracket location inside whilearray
            $prevbracket = $brackets - 1;

            //Check for while nested loop inside another while loop
            if ($whilearray[$prevbracket] != 0) {
                $newccs = $ccs[$whilearray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for while nested loop inside a switch statement
            if ($switcharray[$prevbracket] != 0) {
                $newccs = $ccs[$casearray[$colons]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for while nested loop inside an if statement
            if ($ifarray[$prevbracket] != 0) {
                $newccs = $ccs[$ifarray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for while nested loop inside a for loop
            if ($forarray[$prevbracket] != 0) {
                $newccs = $ccs[$forarray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for  while nested loop inside a do while loop
            if ($dowhilearray[$prevbracket] != 0) {
                $newccs = $ccs[$dowhilearray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
        }
    }
    //Checking 'while' in line without space for bracket
    if ((strpos($lines, 'while(') !== false)) {
        if (strpos($lines, ');') !== false) {
            //Do nothing
        } else {
            $nc[$linesno]++;//add nc
            $wtcs[$linesno] += $wfw;//assign wtcs with weight given for while loop
            $whilearray[$brackets] = $linesno;//Save particular bracket location inside whilearray
            $prevbracket = $brackets - 1;

            //Check for while nested loop inside another while loop
            if ($whilearray[$prevbracket] != 0) {
                $newccs = $ccs[$whilearray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for while nested loop inside a switch statement
            if ($switcharray[$prevbracket] != 0) {
                $newccs = $ccs[$casearray[$colons]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for while nested loop inside an if statement
            if ($ifarray[$prevbracket] != 0) {
                $newccs = $ccs[$ifarray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for while nested loop inside a for loop
            if ($forarray[$prevbracket] != 0) {
                $newccs = $ccs[$forarray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
            //Check for  while nested loop inside a do while loop
            if ($dowhilearray[$prevbracket] != 0) {
                $newccs = $ccs[$dowhilearray[$prevbracket]];
                $ccspps[$linesno] += $newccs;
            }
        }
    }
}

function checkDoWhile($lines, $linesno, $brackets)
{
    //global variable declaration
    global $ccs, $wtcs, $nc, $ccspps, $forarray, $colons, $switcharray, $casearray, $newccs, $ifarray, $whilearray, $wfw, $dowhilearray;

    //Checking 'do' in line with space for bracket
    if (preg_match("/do{/", $lines) > 0) {
        $nc[$linesno]++;//add nc
        $wtcs[$linesno] += $wfw;//assign wtcs with weight given for while loop
        $dowhilearray[$brackets] = $linesno;//Save particular bracket location inside whilearray
        $prevbracket = $brackets - 1;

        //Check for do while nested loop inside another do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside a while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside a switch statement
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside an if statement
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside a for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }

    }
    //Checking 'do' in line with space for bracket
    if (preg_match("/do {/", $lines) > 0) {
        $nc[$linesno]++;//add nc
        $wtcs[$linesno] += $wfw;//assign wtcs with weight given for while loop
        $dowhilearray[$brackets] = $linesno;//Save particular bracket location inside whilearray
        $prevbracket = $brackets - 1;

        //Check for do while nested loop inside another do while loop
        if ($dowhilearray[$prevbracket] != 0) {
            $newccs = $ccs[$dowhilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside a while loop
        if ($whilearray[$prevbracket] != 0) {
            $newccs = $ccs[$whilearray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside a switch statement
        if ($switcharray[$prevbracket] != 0) {
            $newccs = $ccs[$casearray[$colons]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside an if statement
        if ($ifarray[$prevbracket] != 0) {
            $newccs = $ccs[$ifarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }
        //Check for do while nested loop inside a for loop
        if ($forarray[$prevbracket] != 0) {
            $newccs = $ccs[$forarray[$prevbracket]];
            $ccspps[$linesno] += $newccs;
        }

    }

}

//Calculating the final Ccs value function
function calCcs()
{
    //global variable declaration
    global $ccs, $wtcs, $nc, $ccspps;

    //Calculating the ccs value for each line having a control structure component
    for ($i = 1; $i <= sizeof($ccs); $i++) {
        $ccs[$i] = ($wtcs[$i] * $nc[$i]) + $ccspps[$i];//Given formula for the calculation
    }
}
