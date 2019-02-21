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
use App\Entity\Student;
use App\Form\MarkType;
use App\Form\StudentType;
use App\Repository\MarkRepository;
use App\Repository\StudentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage student.
 *
 * @Route("/students")
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class StudentController extends AbstractController
{
    /**
     * @Route("", defaults={"page": "1"}, methods={"GET"}, name="student_index")
     * @Route(
     *     "/page/{page<[1-9]\d*>}",
     *     methods={"GET"},
     *     name="student_index_paginated"
     * )
     * @Cache(smaxage="10")
     *
     * @param int               $page     page
     * @param StudentRepository $students students
     *
     * @return Response
     */
    public function index(int $page, StudentRepository $students): Response
    {
        $latestStudents = $students->findLatest($page);

        return $this->render(
            'student/index.html.twig',
            ['students' => $latestStudents]
        );
    }

    /**
     * Creates a new Student entity.
     *
     * @Route("/new", methods={"GET", "POST"}, name="student_new")
     *
     * @param Request $request request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student)
            ->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager = $this->getDoctrine()->getManager();
            $objectManager->persist($student);
            $objectManager->flush();
            $this->addFlash('success', 'student.created_successfully');
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('student_new');
            }

            return $this->redirectToRoute('student_index');
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Student entity.
     *
     * @Route(
     *     "/{id<\d+>}",
     *     defaults={"page": "1"},
     *     methods={"GET"},
     *     name="student_show"
     * )
     * @Route(
     *     "/{id<\d+>}",
     *     defaults={"id": "1", "page": "1"},
     *     methods={"GET"},
     *     name="student_show_empty"
     * )
     * @Route(
     *     "/{id<\d+>}/page/{page<[1-9]\d*>}",
     *     methods={"GET"},
     *     name="student_show_paginated"
     * )
     *
     * @param Student        $student student
     * @param int            $page    page
     * @param MarkRepository $marks   marks
     *
     * @return Response
     */
    public function show(
        Student $student,
        int $page,
        MarkRepository $marks
    ): Response {
        $latestMarks = $marks->findLatestOfStudent($student, $page);

        return $this->render('student/show.html.twig', [
            'student' => $student,
            'marks' => $latestMarks,
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="student_edit")
     *
     * @param Request $request request
     * @param Student $student student
     *
     * @return Response
     */
    public function edit(Request $request, Student $student): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'student.updated_successfully');

            return $this->redirectToRoute(
                'student_edit',
                ['id' => $student->getId()]
            );
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Student entity.
     *
     * @Route("/{id}/delete", methods={"POST"}, name="student_delete")
     *
     * @param Request $request request
     * @param Student $student student
     *
     * @return Response
     */
    public function delete(Request $request, Student $student): Response
    {
        if (
            !$this->isCsrfTokenValid(
                'delete',
                $request->request->get('token')
            )
        ) {
            return $this->redirectToRoute('student_index');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        $this->addFlash('success', 'student.deleted_successfully');

        return $this->redirectToRoute('student_index');
    }

    /**
     * @Route("/search/{query}", methods={"GET"}, name="student_search")
     * @Cache(smaxage="10")
     *
     * @param string            $query    query
     * @param StudentRepository $students students
     *
     * @return JsonResponse
     */
    public function search(StudentRepository $students, string $query = ''): Response
    {
        $latestStudents = $students->search($query);

        return new JsonResponse($latestStudents);
    }

    /**
     * @Route("/{id}/mark", methods={"GET", "POST"}, name="student_add_mark")
     *
     * @param Request $request request
     * @param Student $student student
     *
     * @return Response
     */
    public function addMark(Request $request, Student $student): Response
    {
        $mark = new Mark();
        $mark->setStudent($student);
        $form = $this->createForm(MarkType::class, $mark)
            ->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mark);
            $em->flush();
            $this->addFlash('success', 'mark.created_successfully');
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute(
                    'student_add_mark',
                    ['id' => $student->getId()]
                );
            }

            return $this->redirectToRoute(
                'student_show',
                ['id' => $student->getId()]
            );
        }

        return $this->render('mark/new.html.twig', [
            'student' => $student,
            'mark' => $mark,
            'form' => $form->createView(),
        ]);
    }
}
