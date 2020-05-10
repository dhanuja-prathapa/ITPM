<?php

//Calculating Cs value
function calCs()
{
    global $nkw,$wkw, $nop,$wop, $nid,$wid, $nnv,$wnv, $nsl,$wsl, $cs;
    for ($i = 1; $i <= sizeof($cs); $i++) {
        $cs[$i] = ($nkw[$i] * $wkw) + ($nid[$i] * $wid) + ($nop[$i] * $wop) + ($nnv[$i] * $wnv) + ($nsl[$i] * $wsl);
    }
}

//Calculating string literals
function stringLiterals($lines)
{
    if (substr_count($lines, '"') != 0) {
        $counts = preg_match_all('/"/', $lines);
        return $counts / 2;
    } else {
        return 0;
    }
}

function sizeCal($codes)
{

    global $nkw, $nop, $nid, $nnv, $nsl, $methods;
    $linesno = 1;
    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        if(preg_match("@//@",$lines,$match)>0){
            $linesno++;
            continue;
        }
        checkformethods($lines,$linesno);
        ifswitch($lines,$linesno);

        foreach ($words as $word) {
            $string_json = file_get_contents("SVM/javaKey.json");
            $pattern = json_decode($string_json, TRUE);
            foreach ($pattern as $i) {
                if ($count = preg_match_all($i, $word) != 0) {
                    $nkw[$linesno] += $count;
                }
            }

//                if (preg_match_all('/=/', $word) != 0) {
//                    $nop[$linesno] += 1;
//                }
//                if(preg_match('/,/', $word, $result) != 0){
//                    $nop[$linesno] += 1;
//                }


            switch ($word) {
                    //keywords

                case 'static':
                case 'class':
                case 'interface':
                    $nkw[$linesno]++;
                    $nid[$linesno]++;
                    break;


            }
        }
        $nsl[$linesno] += stringLiterals($lines);
        numericalVal($lines,$linesno);
        $linesno++;
    }
}

function checkformethods($lines, $lineno){
    global $methods, $nid;
    if (preg_match('/' . implode('|', $methods) . '/',$lines,$found)>0){
       $nid[$lineno] += 1;
    }

}

function ifswitch($lines,$lineno){
    if((preg_match('/\((.*?)\)/i', $lines,$inputpar) != 0) && (preg_match("/if/",$lines) > 0)){

    }

}

function numericalVal($lines,$linesno)
{
    global $nnv, $stringOpen, $stringClose;
    $stringOpen = false;
    $stringClose = true;
    //Need to implement a function to ignore the values in string literals
    $words = explode(" ", $lines);
    foreach ($words as $word) {

        if (substr_count($word, '"')>0){
            $stringOpen = !$stringOpen;
            $stringClose = !$stringClose;
            continue;
        }
        if($stringClose && !$stringOpen){

            $value = preg_match('!\d+!', $word);
            $nnv[$linesno] += $value;//identify the nnv
            //find for nop values if there no strings open
            findNop($word,$linesno,$lines);//search word by word
        }
    }
}

function findNop($word, $linesno, $lines){
    global $nop;
    if(preg_match("/import/", $lines) == 0) {
        if (substr_count($word, "==") != 0) {
            $count = substr_count($word, "==");
            $nop[$linesno] += $count;
        }elseif (substr_count($word, "!=") != 0){ // not gate
            $count = substr_count($word,"!=");
            $nop[$linesno] += $count;
        }else if (substr_count($word, "=") != 0) {
            $count = substr_count($word,"=");
            $nop[$linesno] += $count;
        }

        if (substr_count($word, "++") != 0) {
            $count = substr_count($word,"++");
            $nop[$linesno] += $count;
        }else if (substr_count($word, "+") != 0) {
            $count = substr_count($word,"+");
            $nop[$linesno] += $count;
        }

        if (substr_count($word, "--") != 0) {
            $count = substr_count($word,"--");
            $nop[$linesno] += $count;
        }elseif (substr_count($word, "-") != 0) {
            $count = substr_count($word,"-");
            $nop[$linesno] += $count;
        }
        if (substr_count($word, "/") != 0) {
            $count = substr_count($word,"/");
            $nop[$linesno] += $count;
        }
        if (substr_count($word, "*") != 0) {
            $count = substr_count($word,"*");
            $nop[$linesno] += $count;
        }
        if (substr_count($word, ".") != 0) {
            $count = substr_count($word,".");
            $nop[$linesno] += $count;

        }
        if (substr_count($word, ",") != 0) {
            $count = substr_count($word,",");
            $nop[$linesno] += $count;
        }

        if (substr_count($word, "%") != 0) {
            $count = substr_count($word,"%");
            $nop[$linesno] += $count;
        }

        //AND OR NOT
        if (substr_count($word, "&&") != 0) {
            $count = substr_count($word,"&&");
            $nop[$linesno] += $count;
        }
        if (substr_count($word, "||") != 0) {
            $count = substr_count($word,"||");
            $nop[$linesno] += $count;
        }

    }
}
