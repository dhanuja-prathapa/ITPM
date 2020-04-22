<?php
function numericalVal($lines,$linesno)
{
    //Need to implement a function to ignore the values in string literals
    return (preg_match_all('!\d+!', $lines));
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

function findNid($lines, $linesno)
{
    if (substr_count($lines, "System.out.") != 0) {

        if ($nidcount = (substr_count($lines, "+") + substr_count($lines, "-") + substr_count($lines, "/") + substr_count($lines, "*")) != 0) {
            global $nid;
            $nid[$linesno] += $nidcount;
        }
    }
}

function subOpCount($word, $linesno)
{
    if ($count = substr_count($word, "System.out.") != 0) {
        global $nid;
        $nid[$linesno] += 3;
        return ($count * 2);
    }
    if ($count = (substr_count($word, "++") + substr_count($word, "--")) != 0) {
        return $count;
    } else {
        return 0;
    }
}

function sizeCal($codes)
{
    global $nkw, $nop, $nid, $nnv, $nsl;
    $linesno = 1;
    foreach ($codes as $lines) {
        $words = explode(" ", $lines);
        foreach ($words as $word) {
            $string_json = file_get_contents("javaKey.json");
            $pattern = json_decode($string_json, TRUE);
            foreach ($pattern as $i) {
                if ($count = preg_match_all($i, $word) != 0) {
                    $nkw[$linesno] += $count;
                }
            }
            switch ($word) {
                    //keywords

                case 'static':
                case 'class':
                case 'interface':
                    $nkw[$linesno]++;
                    $nid[$linesno]++;
                    break;

                    //operators
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
        $nnv[$linesno] += numericalVal($lines,$linesno);
        findNid($lines, $linesno);
        $linesno++;
    }
}
