<?php
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
            $nnv[$linesno] += $value;
        }
    }
}

function calCs()
{
    global $nkw, $nop, $nid, $nnv, $nsl, $cs;
    for ($i = 1; $i <= sizeof($cs); $i++) {
        $cs[$i] = $nkw[$i] + $nid[$i] + $nop[$i] + $nnv[$i] + $nsl[$i];
    }
}

function stringLiterals($lines)
{
    if (substr_count($lines, '"') != 0) {
        $counts = preg_match_all('/"/', $lines);
        return $counts / 2;
    } else {
        return 0;
    }
}

//function findNid($lines, $linesno)
//{
//    if (substr_count($lines, "System.out.") != 0) {
//
//        if ($nidcount = (substr_count($lines, "+") + substr_count($lines, "-") + substr_count($lines, "/") + substr_count($lines, "*")) != 0) {
//            global $nid;
//            $nid[$linesno] += $nidcount;
//        }
//    }
//}

function subOpCount($word, $linesno)
{
    if (substr_count($word, "System.out.") != 0) {

        global $nid;
        $nid[$linesno] += 3;
        return 2;
    }
    if ($count = (substr_count($word, "++") + substr_count($word, "--")) != 0) {
        return $count;
    } else {
        return 0;
    }
}

function sizeCal($codes)
{
    methCal($codes);
    global $nkw, $nop, $nid, $nnv, $nsl;
    $linesno = 1;
    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        if(preg_match("@//@",$lines,$match)>0){
            $linesno++;
            continue;
        }
        checkpublic($lines,$linesno);
        checkformethods($lines,$linesno);
        ifswitch($lines,$linesno);
        if(($count = substr_count($lines,".")) > 0){
            if(preg_match("/import/",$lines) == 0)
            $nop[$linesno] += $count;
        }
        foreach ($words as $word) {
            $string_json = file_get_contents("javaKey.json");
            $op_json = file_get_contents("javaOp.json");
            $pattern = json_decode($string_json, TRUE);
            $op_pattern = json_decode($op_json,TRUE);
            foreach ($pattern as $i) {
                if ($count = preg_match_all($i, $word) != 0) {
                    $nkw[$linesno] += $count;
                }
            }

                if (preg_match_all('/=/', $word) != 0) {
                    $nop[$linesno] += 1;
                }
                if(preg_match('/,/', $word, $result) != 0){
                    print_r($result);
                }


            switch ($word) {
                    //keywords

                case 'static':
                case 'class':
                case 'interface':
                    $nkw[$linesno]++;
                    $nid[$linesno]++;
                    break;

                default:
                  subOpCount($word, $linesno);
            }
        }
        $nsl[$linesno] += stringLiterals($lines);
        numericalVal($lines,$linesno);
        //findNid($lines, $linesno);
        $linesno++;
    }
}

function checkpublic($lines,$linesno){
    global $nkw,$nid;
    if (preg_match("/public/",$lines)>0){

        $string_json = file_get_contents("javaReturn.json");
        $pattern = json_decode($string_json, TRUE);
        foreach ($pattern as $i) {
            if ($count = preg_match_all($i, $lines) != 0) {
                $nkw[$linesno] += $count;
            }
        }
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
        print_r($inputpar);
    }

}
