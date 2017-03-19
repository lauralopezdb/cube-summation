<?php
namespace App;

class Cube
{
    protected $matrix = array();
    protected $n = 0;

    public function __construct($n)
    {
        if (is_numeric($n)) {
            $z = 1;
            while ($z <= $n) {
                $x = 1;
                while ($x <= $n) {
                    $y = 1;
                    while ($y <= $n) {
                        $matrix[$x][$y][$z] = 0;
                        $y++;
                    }
                    $x++;
                }
                $z++;
            }
            $this->n = $n;
            $this->matrix = $matrix;
        }
    }

    public function validateInputFormat($input) {
        $input_lines = nl2br($input);
        $lines_array = explode('<br />', $input_lines);
        $line_number = 1;
        $test_case_init_line = 0;
        $iter = 0;
        $n = 0;
        $m = 0;
        $valid = false;
        $total_lines = count($lines_array);
        $test_cases = array();
        if ($total_lines >= 3) {
            foreach ($lines_array as $line) {
                switch ($line_number) {
                    case 1:
                        if (!is_numeric($line) || intval(trim($line)) <= 0 || intval(trim($line)) >= 51) {
                            return $valid;
                        }
                        $test_case_init_line = $line_number+1;
                        $t = intval(trim($line));
                        break;
                    // New test case
                    case $test_case_init_line:
                    case $test_case_init_line+($m+1):
                        $nm_array = explode(' ', trim($line));
                        $nm_param = count($nm_array);
                        if ($nm_param !== 2 || !is_numeric($nm_array[0]) || !is_numeric($nm_array[1]) || 
                            intval($nm_array[0]) <= 0 || intval($nm_array[0]) >=101 ||
                            intval($nm_array[1]) <= 0 || intval($nm_array[1]) >= 1001) {
                            return $valid;
                        }
                        $iter++;
                        $n = intval($nm_array[0]);
                        $m = intval($nm_array[1]);
                        $test_cases[$iter]['n'] = $n;
                        $test_cases[$iter]['operations'] = array();
                        break;
                    // Test case operations                        
                    default:
                        $operation = explode(' ', strtolower(trim($line)));
                        $operation_param = count($operation);
                        if ($operation[0] !== 'update' && $operation[0] !== 'query') {
                            return $valid;
                        }
                        break;
                }
                $line_number++;
            }
            if ($iter !== $t) {
                return $valid;
            } else {
                $valid = true;
                return $valid;
            }
        }
    }

    public function validateUpdate($update_line) {
        $valid = false;
        $n = intval($this->n);
        $update_array = explode(' ', trim(strtolower($update_line)));
        if (count($update_array) === 5 && $update_array[0] === 'update') {
            if (is_numeric($update_array[1]) && is_numeric($update_array[2]) && 
                is_numeric($update_array[3]) && is_numeric($update_array[4])) {
                $x = intval($update_array[1]);
                $y = intval($update_array[2]);
                $z = intval($update_array[3]);
                $w = intval($update_array[4]);
                if ($x >= 1 && $x <= $n && 
                    $y >= 1 && $y <= $n && 
                    $z >= 1 && $z <= $n && 
                    $w >= pow(-10, 9) && $w <= pow(10, 9)) {
                    $valid = true;
                }
            }
        }   
        return $valid;
    }

    public function updateCube($update_line) {
        $update_array = explode(' ', $update_line);
        $x = intval($update_array[1]);
        $y = intval($update_array[2]);
        $z = intval($update_array[3]);
        $w = intval($update_array[4]);
        $this->matrix[$x][$y][$z] = $w;
        return $this->matrix[$x][$y][$z];
    }

    public function validateQuery($query_line) {
        $valid = false;
        $n = intval($this->n);
        $query_array = explode(' ', trim(strtolower($query_line)));
        if (count($query_array) === 7 && $query_array[0] === 'query') {
            if (is_numeric($query_array[1]) && is_numeric($query_array[2]) && 
                is_numeric($query_array[3]) && is_numeric($query_array[4]) &&
                is_numeric($query_array[5]) && is_numeric($query_array[6])) {
                $x1 = intval($query_array[1]);
                $y1 = intval($query_array[2]);
                $z1 = intval($query_array[3]);
                $x2 = intval($query_array[4]);
                $y2 = intval($query_array[5]);
                $z2 = intval($query_array[6]);
                if ($x1 >= 1 && $x1 <= $x2 && $x2 <= $n && 
                    $y1 >= 1 && $y1 <= $y2 && $y2 <= $n &&
                    $z1 >= 1 && $z1 <= $z2 && $z2 <= $n){
                    $valid = true;
                }
            }
        }   
        return $valid;
    }

    public function queryCube($query_line) {
        $query_array = explode(' ', $query_line);
        $x1 = intval($query_array[1]);
        $y1 = intval($query_array[2]);
        $z1 = intval($query_array[3]);
        $x2 = intval($query_array[4]);
        $y2 = intval($query_array[5]);
        $z2 = intval($query_array[6]);
        $z = $z1;
        $sum = 0;
        while ($z <= $z2) {
            $x = $x1;
            while ($x <= $x2) {
                $y = $y1;
                while ($y <= $y2) {
                    $sum = $sum + $this->matrix[$x][$y][$z];
                    $y++;
                }
                $x++;
            }
            $z++;
        }
        return $sum;
    }
}