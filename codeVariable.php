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
                    $words = explode(" ", $lines);
                    $arraySize = sizeof($words);
                    $npdtv[$linesno] += ($arraySize - 2);
                    $composite = false;
                }
            }
            //composite
            if (preg_match('([A-Z][^\s]*)', $lines, $matches)>0 && $composite && (preg_match("/System/",$lines) == 0) ){
                $wvs[$linesno] = 2;
                $wordsC = explode(" ", $lines);
                $arraySizeC = sizeof($wordsC);
                $npctv[$linesno] += ($arraySizeC - 2);
            }
          }
    }else{
        //local variable
        if((preg_match("/public/",$lines) == 0) && (preg_match("/System/",$lines) == 0)){
            $composite = true;
            $string_json = file_get_contents("javaReturn.json");
            $pattern = json_decode($string_json, TRUE);
            foreach ($pattern as $i) {
                if (preg_match($i, $lines) != 0) {
                    $wvs[$linesno] += 1;
                    $words = explode(" ", $lines);
                    $arraySize = sizeof($words);
                    $npdtv[$linesno] += ($arraySize - 1);
                    $composite = false;
                }
            }

            //composite
//            if (preg_match('([A-Z][^\s]*)', $lines, $matches)>0 && $composite ){
//                $wvs[$linesno] = 1;
//                $wordsC = explode(" ", $lines);
//                $arraySizeC = sizeof($wordsC);
//                $npctv[$linesno] += ($arraySizeC - 1);
//            }
        }

    }
}

function calCv(){
    global $wvs, $npdtv, $npctv, $cv, $wpdtv, $wpctv;

    for ($j = 1; $j <= sizeof($cv); $j++){
        $cv[$j] = $wvs[$j] * (($wpdtv * $npdtv[$j]) + ($wpctv * $npctv[$j]));
    }
}



?>