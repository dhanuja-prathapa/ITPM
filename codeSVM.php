<?php
function numericalVal($lines){
    $count = preg_match_all('!\d+!', $lines);
    return $count;
}
function calCs(){
    global $nkw,$nop,$nid,$nnv,$nsl,$cs;
    for ($i = 1; $i <= sizeof($cs); $i++){
        $cs[$i] = $nkw[$i] + $nid[$i] + $nop[$i] + $nnv[$i] + $nsl[$i];
    }
}
function stringLiterals($lines){
    if ($count = substr_count($lines,'"') != 0){
        $counts = preg_match_all('/"/', $lines);
        return $counts/2;
    }else return 0;
}
function findNid($lines,$linesno){
    if ($count = substr_count($lines,"System.out.") != 0){
        if ($nidcount = (substr_count($lines,"+") + substr_count($lines,"-") + substr_count($lines,"/") + substr_count($lines,"*"))!= 0){
            global $nid;
            $nid[$linesno] += $nidcount;
        }
    }
}
function subOpCount($word,$linesno){
    if ($count = substr_count($word,"System.out.") != 0 ){
        global $nid;
        $nid[$linesno] += 3;
        return ($count * 2);
    }else if ($count = (substr_count($word,"++") + substr_count($word,"--")) != 0){
        return $count;
    }
    else return 0;
}
function sizeCal ($codes)
{
    global $nkw,$nop,$nid,$nnv,$nsl;
    $linesno = 1;
    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        foreach ($words as $word) {
            switch ($word) {
                //keywords
                case 'continue':
                case 'final':
                case 'implements':
                case 'super':
                case 'package':
                case 'protected':
                case 'private':
                case 'this':
                case 'break':
                case 'null':
                case 'return':
                case 'default':
                case 'false':
                case 'true':
                case 'void':
                case 'public':
                case 'import':
                    $nkw[$linesno]++;
                    break;
                case 'static':
                case 'class':
                case 'interface':
                    $nkw[$linesno]++;
                    $nid[$linesno]++;
                    break;

                //operators
                case '>':
                case '>=':
                case '<':
                case '-':
                case '*':
                case '/':
                case '%':
                case '++':
                case '--':
                case '==':
                case '!=':
                case '<=':
                case '&&':
                case '||':
                case '!':
                case '|':
                case '^':
                case '~':
                case '<<':
                case '>>':
                case '>>>':
                case '<<<':
                case ',':
                case '->':
                case '.':
                case '::':
                case '+=':
                case '-=':
                case '*=':
                case '/=':
                case '=':
                case '>>>=':
                case '|=':
                case '&=':
                case '%=':
                case '<<=':
                case '>>=':
                case '^=':
                case '+':
                    $nop[$linesno]++;
                    break;

                default:
                    $nop[$linesno] += subOpCount($word, $linesno);
            }

        }
        $nsl[$linesno] += stringLiterals($lines);
        $nnv[$linesno] += numericalVal($lines);
        findNid($lines,$linesno);
        $linesno++;
    }
}