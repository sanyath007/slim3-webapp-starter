<?php
namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index($request, $response, $args) 
    {
		$users = User::all();

		return $res->withJson([
			$users
		]);
    }

    public function user($req, $res, $args)
    {
    	try {
			$cid = $args['cid'];
			$conn = $this->db;

			$sql = "SELECT * 
					FROM users 
					WHERE (cid=:cid)";

			$pre = $conn->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
			$values = [':cid' => $cid];

			$pre->execute($values);
			$result = $pre->fetch();

			if ($result) {
				return $res->withJson([
					'employee' => [
						'cid' => $result['emp_id'],
						'fullName' => $result['prefix'] . $result['emp_fname']. ' ' .$result['emp_lname'],
						'position' => $result['position_name']
					]
				], 200);
			} else {
				return $res->withJson([
					$result
				]);
			}		
		} catch (Exception $e) {
			return $res->withJson([
				'error' => $e->getMessage()
			], 442);
		}
    }
}