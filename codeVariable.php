<?php
function varCal($codes){
    global $brackets;
    $brackets = 0;
    //find class
    $linesno = 1;
    foreach ($codes as $lines) {
        Varbracketcount($lines,$linesno);
        $linesno++;
    }
    //find if it is a  variable

}


function Varbracketcount($lines,$linesno){
    global $brackets, $ifarray;
    if(preg_match("/{/",$lines)>0){
        $brackets += 1;

    }
    if(preg_match("/}/",$lines)>0){

        $ifarray[$brackets] = 0;
        $brackets -= 1;
    }
    if(preg_match("@//@",$lines) == 0) {
        checkVar($lines, $linesno, $brackets);


    }

}


function checkVar($lines, $linesno, $brackets){
    global $brackets, $wvs, $npdtv, $npctv, $cv;
    if($brackets == 1){
        //global variable
        if(preg_match("/private/",$lines)>0){
            $composite = true;
            //not composite
            $string_json = file_get_contents("javaReturn.json");
            $pattern = json_decode($string_json, TRUE);
            foreach ($pattern as $i) {
                if (preg_match($i, $lines) != 0) {
                    $wvs[$linesno] += 2;
                    $words = preg_split("/[^\w]*([\s]+[^\w]*|$)/",$lines,-1, PREG_SPLIT_NO_EMPTY);
                    $arraySize = sizeof($words);
                    $npdtv[$linesno] += ($arraySize - 2);
                    $composite = false;
                }
            }
            //composite
            if (preg_match('([A-Z][^\s]*)', $lines, $matches)>0 && $composite && (preg_match("/System/",$lines) == 0) ){
                $wvs[$linesno] = 2;
                $wordsC = preg_split("/[^\w]*([\s]+[^\w]*|$)/",$lines,-1, PREG_SPLIT_NO_EMPTY);
                $arraySizeC = sizeof($wordsC);
                $npctv[$linesno] += ($arraySizeC - 2);
            }
          }
    }else{
        //local variable
        if((preg_match("/public/",$lines) == 0) && (preg_match("/System/",$lines) == 0)) {
            $composite = true;
            $string_json = file_get_contents("javaReturn.json");
            $pattern = json_decode($string_json, TRUE);
            foreach ($pattern as $i) {
                preg_match('/\((.*?)\)/i', $lines, $parameters);
                if(empty($parameters)){
                    $parameters[0] = 0;
                }
                if ((preg_match($i, $lines, $results) != 0) && (preg_match($i, $parameters[0]) == 0)) {
                    $wvs[$linesno] += 1;
                    $words = preg_split("/[^\w]*([\s]+[^\w]*|$)/", $lines, -1, PREG_SPLIT_NO_EMPTY);// remove blank space in array and split into words
                    $arraySize = sizeof($words);
                    if (preg_match('/\((.*?)\)/i', $lines, $found)) {
                        $npdtv[$linesno] = 1;
                    } else {
                        $npdtv[$linesno] += ($arraySize - 1);
                    }
                    $composite = false;
                }
            }

            //composite
            $line_no = ltrim($lines);   //remove front whitespace
            $classFound = false;
            if($line_no !== '') {
                if (($line_no[0]) == strtoupper($line_no[0])) {
                    $classFound = true;
                }
                if (preg_match('([A-Z][^\s]*)', $lines, $matches) > 0 && $composite && $classFound) {
                    $wvs[$linesno] = 1;
                    $wordsC = preg_split("/[^\w]*([\s]+[^\w]*|$)/", $lines, -1, PREG_SPLIT_NO_EMPTY);
                    $arraySizeC = sizeof($wordsC);
                    if (preg_match('/\((.*?)\)/i', $lines, $found)) {
                        $npctv[$linesno] = 1;
                    }
                    else{
                        $npctv[$linesno] += ($arraySizeC - 1);
                    }
                }
            }
        }

    }
}

function calCv(){
    global $wvs, $npdtv, $npctv, $cv, $wpdtv, $wcdtv;

    for ($j = 1; $j <= sizeof($cv); $j++){
        $cv[$j] = $wvs[$j] * (($wpdtv * $npdtv[$j]) + ($wcdtv * $npctv[$j]));
    }
}



?>