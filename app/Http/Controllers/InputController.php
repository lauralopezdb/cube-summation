<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InputController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validate(Request $request)
    {
        $input = trim($request->input('inputText'));
        $input_lines = nl2br($input);
        $lines_array = explode('<br />', $input_lines);
        $line_number = 1;
        $test_case_init_line = 0;
        $iter = 0;
        $n = 0;
        $m = 0;
        $msg = '';
        $total_lines = count($lines_array);
        $test_cases = array();
        if ($total_lines < 3) {
            $msg = 'Input must contain at least 3 lines';
            return $msg;
        } else {
            foreach ($lines_array as $line) {
                switch ($line_number) {
                    case 1:
                        if (is_numeric($line)) {
                            $t = intval(trim($line));
                            if ( $t <= 0 || $t >= 51 ) {
                                $msg = 'T must be an integer between 1 and 50';
                                return $msg;
                            }
                        } else {
                            $msg = 'The first line must contain an integer T, the number of test cases';
                            return $msg;
                        }
                        $test_case_init_line = $line_number+1;
                        break;
                    // New test case
                    case $test_case_init_line:
                    case $test_case_init_line+($m+1):
                        $nm_array = explode(' ', trim($line));
                        $nm_param = count($nm_array);
                        if ($nm_param !== 2) {
                            $msg = 'For each test case, the first line will contain two integers N and M separated by a single space';
                            return $msg;
                        } else {
                            if (is_numeric($nm_array[0]) && is_numeric($nm_array[1])) {
                                $n = intval($nm_array[0]);
                                if ( $n <= 0 || $n >= 101 ) {
                                    $msg = 'For each test case N must be an integer between 1 and 100';
                                    return $msg;
                                }
                                $m = intval($nm_array[1]);
                                if ( $m <= 0 || $m >= 1001 ) {
                                    $msg = 'For each test case M must be an integer between 1 and 1000';
                                    return $msg;
                                }
                            } else {
                                $msg = 'For each test case N and M must be integers';
                                return $msg;
                            }
                        }
                        $iter++;
                        $test_cases[$iter]['n'] = $n;
                        $test_cases[$iter]['operations'] = array();
                        break;
                    // Test case operations                        
                    default:
                        $operation = explode(' ', strtolower(trim($line)));
                        $operation_param = count($operation);
                        if ($operation[0] === 'update' || $operation[0] === 'query') {
                            if ($operation[0] === 'update') {
                                if ($operation_param === 5 && 
                                    is_numeric($operation[1]) && is_numeric($operation[2]) && 
                                    is_numeric($operation[3]) && is_numeric($operation[4])) {
                                    $x = intval($operation[1]);
                                    $y = intval($operation[2]);
                                    $z = intval($operation[3]);
                                    $w = intval($operation[4]);
                                    if ($x <= 0 || $x > $n || 
                                        $y <= 0 || $y > $n || 
                                        $z <= 0 || $z > $n || 
                                        $w < pow(-10, 9) || $w > pow(10, 9)) {
                                        $msg = 'Parameters incorrect for UPDATE operation';
                                        return $msg;
                                    } else {
                                        $oper_line = 'update ' . $x . ' ' . $y . ' ' . $z . ' ' . $w;
                                        array_push($test_cases[$iter]['operations'], $oper_line);
                                    }
                                } else {
                                    $msg = 'Parameters incorrect for UPDATE operation';
                                    return $msg;
                                }
                            }
                            if ($operation[0] === 'query') {
                                if ($operation_param === 7 &&
                                    is_numeric($operation[1]) && is_numeric($operation[2]) && 
                                    is_numeric($operation[3]) && is_numeric($operation[4]) &&
                                    is_numeric($operation[5]) && is_numeric($operation[6])) {
                                    $x1 = intval($operation[1]);
                                    $y1 = intval($operation[2]);
                                    $z1 = intval($operation[3]);
                                    $x2 = intval($operation[4]);
                                    $y2 = intval($operation[5]);
                                    $z2 = intval($operation[6]);
                                    if ($x1 <= 0 || $x1 > $x2 || $x2 > $n || 
                                        $y1 <= 0 || $y1 > $y2 || $y2 > $n ||
                                        $z1 <= 0 || $z1 > $z2 || $z2 > $n) {
                                        $msg = 'Parameters incorrect for QUERY operation';
                                        return $msg;
                                    } else {
                                        $oper_line = 'query ' . $x1 . ' ' . $y1 . ' ' . $z1 . ' ' . $x2 . ' ' . $y2 . ' ' . $z2;
                                        array_push($test_cases[$iter]['operations'], $oper_line);
                                    }
                                } else {
                                    $msg = 'Parameters incorrect for QUERY operation';
                                    return $msg;
                                }
                            }
                        } else {
                            $msg = 'Test cases operations must be from UPDATE or QUERY type';
                            return $msg;
                        }
                        break;
                }
                $line_number++;
            }
            if ($iter !== $t) {
                $msg = 'Incorrect number of test cases';
                return $msg;
            } else {
                return $test_cases;
            }
        }
    }
}