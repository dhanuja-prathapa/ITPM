function for($codes){
global $nkw,$nop,$nid,$nnv,$nsl;
    $linesno = 1;
    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        foreach ($words as $word) {
            $string_json = file_get_contents("javaKey.json");
            $pattern = json_decode($string_json,TRUE);
            foreach ($pattern as $i){
            if($count = preg_match_all($i,$word) != 0){
                $nkw[$linesno] += $count;
            }
            }
        }
    }
}