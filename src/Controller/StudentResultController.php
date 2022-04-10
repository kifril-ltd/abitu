<?php

namespace App\Controller;

use App\Entity\StudentResult;
use App\Form\StudentResultType;
use App\Repository\StudentResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student/result')]
class StudentResultController extends AbstractController
{
    #[Route('/', name: 'app_student_result_index', methods: ['GET'])]
    public function index(StudentResultRepository $studentResultRepository): Response
    {
        return $this->render('student_result/index.html.twig', [
            'student_results' => $studentResultRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_result_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentResultRepository $studentResultRepository): Response
    {
        $studentResult = new StudentResult();
        $form = $this->createForm(StudentResultType::class, $studentResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentResultRepository->add($studentResult);
            return $this->redirectToRoute('app_student_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_result/new.html.twig', [
            'student_result' => $studentResult,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_result_show', methods: ['GET'])]
    public function show(StudentResult $studentResult): Response
    {
        return $this->render('student_result/show.html.twig', [
            'student_result' => $studentResult,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_result_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StudentResult $studentResult, StudentResultRepository $studentResultRepository): Response
    {
        $form = $this->createForm(StudentResultType::class, $studentResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentResultRepository->add($studentResult);
            return $this->redirectToRoute('app_student_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_result/edit.html.twig', [
            'student_result' => $studentResult,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_result_delete', methods: ['POST'])]
    public function delete(Request $request, StudentResult $studentResult, StudentResultRepository $studentResultRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentResult->getId(), $request->request->get('_token'))) {
            $studentResultRepository->remove($studentResult);
        }

        return $this->redirectToRoute('app_student_result_index', [], Response::HTTP_SEE_OTHER);
    }
}
