<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;

class PatientController
{
	protected $container;
    protected $view;

    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
        $this->view = $container['view'];
    }

    public function getAll($req, $res, $args)
    {
        $conn = $this->container['db'];
        $result = $conn->query("SELECT * FROM patient limit 10");
        $patients = $result->fetchAll(\PDO::FETCH_OBJ);
        
        $this->view->render($res, 'patient.html.twig', [
            'patients' => $patients
        ]);
    }
    
    public function getByCid($req, $res, $args)
    {
        $cid = $args['cid'];
        $conn = $this->container['db'];

        $result = $conn->prepare("SELECT * FROM patient WHERE (cid=:cid)", [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $values = [':cid' => $cid];

        $result->execute($values);
        $patient = $result->fetch(\PDO::FETCH_OBJ);

        $this->view->render($res, 'patient.html.twig', [
            'patient' => $patient
        ]);
    }
}
