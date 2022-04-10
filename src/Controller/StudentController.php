<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\University;
use App\Form\SpecializationListType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use App\RpcConnection\RpcClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'app_student_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentRepository $studentRepository, University $university): Response
    {
        $student = new Student();
        $student->setUniversity($university);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRepository->add($student);
            $rpc = new RpcClient($student->getUniversity()->getName() . '_queue', false);
            $data = ['student_passport' => $student->getPassport()];
            $rpc->call(json_encode($data));
            $rpc->close();
            return $this->redirectToRoute('app_university_show', ['id' => $university->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_show', methods: ['GET'])]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRepository->add($student);
            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_delete', methods: ['POST'])]
    public function delete(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $studentRepository->remove($student);
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add', name: 'app_student_spec_add', methods: ['GET','POST'])]
    public function add(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        $form = $this->createForm(SpecializationListType::class, null, ['univ' => $student->getUniversity()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student->addSpecialization($form->getData()['specialization']);
            $studentRepository->add($student);
            return $this->redirectToRoute('app_student_show', ['id' => $student->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/add_spec.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }
}
