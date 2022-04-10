<?php

namespace App\Controller;

use App\Entity\Specialization;
use App\Entity\University;
use App\Form\SpecializationType;
use App\Repository\SpecializationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/specialization')]
class SpecializationController extends AbstractController
{
    #[Route('/', name: 'app_specialization_index', methods: ['GET'])]
    public function index(SpecializationRepository $specializationRepository): Response
    {
        return $this->render('specialization/index.html.twig', [
            'specializations' => $specializationRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_specialization_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpecializationRepository $specializationRepository, University $university): Response
    {
        $specialization = new Specialization();
        $specialization->setUniversity($university);
        $form = $this->createForm(SpecializationType::class, $specialization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specializationRepository->add($specialization);
            return $this->redirectToRoute('app_university_show', ['id' => $university->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specialization/new.html.twig', [
            'specialization' => $specialization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_specialization_show', methods: ['GET'])]
    public function show(Specialization $specialization): Response
    {
        return $this->render('specialization/show.html.twig', [
            'specialization' => $specialization,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_specialization_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specialization $specialization, SpecializationRepository $specializationRepository): Response
    {
        $form = $this->createForm(SpecializationType::class, $specialization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specializationRepository->add($specialization);
            return $this->redirectToRoute('app_specialization_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specialization/edit.html.twig', [
            'specialization' => $specialization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_specialization_delete', methods: ['POST'])]
    public function delete(Request $request, Specialization $specialization, SpecializationRepository $specializationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialization->getId(), $request->request->get('_token'))) {
            $specializationRepository->remove($specialization);
        }

        return $this->redirectToRoute('app_specialization_index', [], Response::HTTP_SEE_OTHER);
    }
}
