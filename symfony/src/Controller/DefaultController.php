<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default Controller that will redirect / to /students
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="homepage")
     * @return Response
     */
    public function homepage(): Response
    {
        return $this->redirectToRoute('student_index');
    }
}
