<?php
namespace App\Controllers;

class PatientController extends Controller
{
    public function getAll($req, $res, $args)
    {
        $result = $this->db->query("SELECT * FROM patient limit 10");
        $patients = $result->fetchAll(\PDO::FETCH_OBJ);
        
        $this->view->render($res, 'patient.twig', [
            'patients' => $patients
        ]);
    }
    
    public function getByCid($req, $res, $args)
    {
        $cid = $args['cid'];

        $result = $this->db->prepare("SELECT * FROM patient WHERE (cid=:cid)", [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $values = [':cid' => $cid];

        $result->execute($values);
        $patient = $result->fetch(\PDO::FETCH_OBJ);

        $this->view->render($res, 'patient.twig', [
            'patient' => $patient
        ]);
    }
}
