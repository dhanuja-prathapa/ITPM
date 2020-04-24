<?php
        function inhcal($codes,$inhSize){
                global $classname, $ndi, $nidi, $ti, $ci, $found;
                $linesno = 1;
                $found = 0;
                foreach ($codes as $lines) {
                        checkclass($lines,$linesno,$found);
                        $linesno++;
                }
        }

        function checkclass($lines,$linesno,$found){
                global $classname, $ndi, $nidi, $ti, $ci, $found;

                if(preg_match("/class/",$lines) > 0) {
                        $found += 1;
                        if (preg_match("@//@", $lines) == 0) {
                                preg_match('([A-Z][^\s]*)', $lines, $matches);
                                $classname[$found] = $matches[0];

                        }
                }
        }
?>
