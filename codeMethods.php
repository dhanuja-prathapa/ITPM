<?php
//main method code will be analyze line by line
function methCal($codes){
    global $methods;
    $methods = array();
    $linesno = 1;
    foreach ($codes as $lines) {
        methodCheck($lines,$linesno);
        $linesno++;
    }

}

function methodCheck($lines,$linesno){
    global $methods, $ncdtp,$npdtp, $wmrt;
    if ((preg_match('/public/',$lines) != 0) && (preg_match('/class/',$lines) == 0)  && (preg_match('/main/',$lines) == 0)){
        if(preg_match('/\((.*?)\)/i', $lines,$inputpar) != 0){
            $words = explode(" ", $lines);
            //finding the best match methodname
            $percentage = 0;
            $match = null;

            foreach ($words as $word){
                similar_text($inputpar[0],$word,$percent);

                if ($percentage < $percent){
                    $percentage = $percent;
                    $match = $word;
                }
            }
            $position = strpos($match,"(");
            $methodname = substr($match,0,$position);
            array_push($methods,$methodname);
            $param = preg_split("/[^\w]*([\s]+[^\w]*|$)/",$inputpar[1],-1, PREG_SPLIT_NO_EMPTY);
            $paramcount = sizeof($param) / 2;
            foreach ($param as $parameter){
                //checking for primitive param
                $string_json = file_get_contents("javaReturn.json");
                $pattern = json_decode($string_json, TRUE);
                foreach ($pattern as $i) {
                    if (preg_match($i, $parameter,$matchfound) != 0) {
                       $npdtp[$linesno] += 1;
                    }
                }

                //check for param non primitive
                if ((preg_match('([A-Z][^\s]*)',$parameter,$results)>0) && (preg_match("/String/",$parameter) == 0)){
                    $ncdtp[$linesno] += 1;

                }
            }




            //return primitive
            $string_json = file_get_contents("javaReturn.json");
            $pattern = json_decode($string_json, TRUE);
            foreach ($pattern as $i) {
                if (preg_match($i, $lines,$results) != 0) {
                    if ($results[0] == 'String'){
                        $wmrt[$linesno] = 2;
                    }elseif ($results[0] == 'void'){
                        $wmrt[$linesno] = 0;
                    }
                    else{
                        $wmrt[$linesno] = 1;
                    }
                }
            }
            //return composite
            $result=preg_split('/public/',$lines);
            if(count($result)>1){
                $result_split=explode(' ',$result[1]);
                if ((preg_match('([A-Z][^\s]*)',$result_split[1], $results)>0) && (preg_match("/String/",$result_split[1])) != 0){
                    $wmrt[$linesno] = 2;
                }
            }

        }
    }
}


//calculating CM
function calCm(){
    global $cm, $wmrt, $wpdtp, $wcdtp, $ncdtp, $npdtp;
    for ($i = 1; $i <= sizeof($cm); $i++){
        $cm[$i] = $wmrt[$i] + ($wpdtp * $npdtp[$i]) + ($wcdtp * $ncdtp[$i]);
    }

}


?>