<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExceptionController extends AbstractController
{
    public function showException()
    {
        $data['@context'] = "/contexts/Error";
        $data['@type'] = "Error";
        $data['hydra:title'] = "An error occurred";
        $data['hydra:description'] = "404 not found - This page does not exist";

        return $this->json($data, 404);
    }
}