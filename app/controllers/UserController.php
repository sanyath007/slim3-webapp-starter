<?php
namespace App\Controllers;

class UserController extends Controller
{
    public function index($request, $response, $args) 
    {
		$users = new \App\Models\User;

		var_dump($users);
    }

    public function user($req, $res, $args)
    {
    	try {
			$cid = $args['cid'];
			$conn = $this->db;

			$sql = "SELECT e.*, p.position_name 
					FROM employees e 
					LEFT JOIN positions p ON (e.position_id=p.id) 
					WHERE (emp_id=:cid)";

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