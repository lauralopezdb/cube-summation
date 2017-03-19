<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SummationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function operate(Request $request)
    {
        $test_cases = $request->input('testCases');
        $query_results = array();
        foreach ($test_cases as $test_case) {
            $n = $test_case['n'];
            $cube = array();
            $z = 1;
            while ($z <= $n) {
                $x = 1;
                while ($x <= $n) {
                    $y = 1;
                    while ($y <= $n) {
                        $cube[$x][$y][$z] = 0;
                        $y++;
                    }
                    $x++;
                }
                $z++;
            }
            $operations = $test_case['operations'];
            foreach ($operations as $operation) {
                $oper_array = explode(' ', $operation);
                if ($oper_array[0] === 'update') {
                    $x = intval($oper_array[1]);
                    $y = intval($oper_array[2]);
                    $z = intval($oper_array[3]);
                    $w = intval($oper_array[4]);
                    $cube[$x][$y][$z] = $w;
                }
                if ($oper_array[0] === 'query') {
                    $x1 = intval($oper_array[1]);
                    $y1 = intval($oper_array[2]);
                    $z1 = intval($oper_array[3]);
                    $x2 = intval($oper_array[4]);
                    $y2 = intval($oper_array[5]);
                    $z2 = intval($oper_array[6]);
                    $z = $z1;
                    $sum = 0;
                    while ($z <= $z2) {
                        $x = $x1;
                        while ($x <= $x2) {
                            $y = $y1;
                            while ($y <= $y2) {
                                $sum = $sum + $cube[$x][$y][$z];
                                $y++;
                            }
                            $x++;
                        }
                        $z++;
                    }
                    array_push($query_results, $sum);
                }
            }
        }
        return $query_results;
    }
}