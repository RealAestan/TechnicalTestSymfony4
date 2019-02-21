<?php
/**
 * This file is part of TechnicalTestSymfony4.
 *
 * @author    Anthony Margerand <anthony.margerand@protonmail.com>
 * @link    https://github.com/RealAestan/TechnicalTestSymfony4
 * @license GPL
 */
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Mark;
use App\Form\MarkType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage mark.
 *
 * @Route("/marks")
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class MarkController extends AbstractController
{
    /**
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="mark_edit")
     *
     * @param Request $request request
     * @param Mark    $mark    mark
     *
     * @return Response
     */
    public function edit(Request $request, Mark $mark): Response
    {
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'mark.updated_successfully');

            return $this->redirectToRoute('mark_edit', ['id' => $mark->getId()]);
        }

        return $this->render('mark/edit.html.twig', [
            'mark' => $mark,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Mark entity.
     *
     * @Route("/{id}/delete", methods={"POST"}, name="mark_delete")
     *
     * @param Request $request request
     * @param Mark    $mark    mark
     *
     * @return Response
     */
    public function delete(Request $request, Mark $mark): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('mark_index');
        }
        $objectManager = $this->getDoctrine()->getManager();
        $objectManager->remove($mark);
        $objectManager->flush();
        $this->addFlash('success', 'mark.deleted_successfully');

        return $this->redirectToRoute('mark_index');
    }
}
