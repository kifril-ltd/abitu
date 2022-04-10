<?php

namespace App\Controller;

use App\Entity\StudentResult;
use App\Entity\University;
use App\Message\TestMessage;
use App\Repository\StudentRepository;
use App\Repository\StudentResultRepository;
use App\Repository\SubjectRepository;
use App\RpcConnection\RpcClient;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class IntegrationController extends AbstractController
{
    #[Route('/integration/{id}', name: 'app_integration', methods: ['POST'])]
    public function index(University $university, StudentRepository $studentRepository, SubjectRepository $subjectRepository, StudentResultRepository $studentResultRepository): Response
    {

        $rpc = new RpcClient($university->getName() . '_queue', false);

        $data = $rpc->get();
        $students = [];

        foreach ($data as $val) {
            $students[] = json_decode($val, true);
        }
        foreach ($students as $student) {
            $studentEntity = $studentRepository->findOneBy(['passport'=>$student['passport']]);
            foreach ($student['subjects'] as $subject) {
                $subjectEntity = $subjectRepository->findOneBy(['code' => $subject['code']]);
                $studentResult = new StudentResult();
                $studentResult->setStudent($studentEntity);
                $studentResult->setSubject($subjectEntity);
                $studentResult->setResult((int)$subject['result']);
                $studentResultRepository->add($studentResult);
            }
        }
        return $this->redirectToRoute('app_university_show', ['id' => $university->getId()]);
    }
}
