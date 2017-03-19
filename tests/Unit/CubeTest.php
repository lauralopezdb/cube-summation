<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Cube;

class CubeTest extends TestCase
{
	public function testCubeOperations() {
		// Create matrix with given dimension
		$cube = new Cube(4);

		// Validate T, N & M lines with integer values, operation lines with update/query strings, 
		// M lines expected for each test case, T test cases expected
		$input = '2
				4 5
				UPDATE 2 2 2 4
				QUERY 1 1 1 3 3 3
				UPDATE 1 1 1 23
				QUERY 2 2 2 4 4 4
				QUERY 1 1 1 3 3 3
				2 4
				UPDATE 2 2 2 1
				QUERY 1 1 1 1 1 1
				QUERY 1 1 1 2 2 2
				QUERY 2 2 2 2 2 2';
		$this->assertTrue($cube->validateInputFormat($input));

		// Result from query before any update must be cero
		$query_line = 'query 2 2 2 2 2 2';
		$this->assertTrue($cube->validateQuery($query_line)); // Validate operation constraints before executing it
		$this->assertEquals(0, $cube->queryCube($query_line));	

		// Result from update must be the last value given for the operation
		$update_line = 'update 2 2 2 4';
		$this->assertTrue($cube->validateUpdate($update_line)); // Validate operation constraints before executing it
		$this->assertEquals(4, $cube->updateCube($update_line));

		// Result from query after update must be the summation of values within given coordinates
		$query_line = 'query 1 1 1 3 3 3';
		$this->assertTrue($cube->validateQuery($query_line)); // Validate operation constraints before executing it
		$this->assertEquals(4, $cube->queryCube($query_line));	

	}
}