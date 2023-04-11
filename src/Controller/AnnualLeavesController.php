<?php

namespace App\Controller;

namespace App\Controller; 
use App\Entity\AnnualLeave;
use App\Repository\AnnualLeaveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnualLeavesController extends AbstractController
{
    private $annualLeaveRepository;
    public function __construct(AnnualLeaveRepository $annualLeaveRepository, EntityManagerInterface $em)
    {
       $this->annualLeaveRepository = $annualLeaveRepository;
       $this->em = $em;
    }


    #[Route('/annual/leaves', methods: ['GET'], name: 'annual_leaves')]
    public function index(): Response
    {
        $new_annual_leave = $this->annualLeaveRepository->findAll();
        dd($new_annual_leave);

        #return $this->render('index.html.twig');
    }

    #[Route('/annual/leaves/{starDate}-{endDate}', methods: ['GET'], name: 'show_annual_leave')]
    public function show($starDate, $endDate): Response
    {
        $annual_leave = $this->annualLeaveRepository->findOneBy(['starDate' => $starDate, 'endDate' => $endDate], ['id' => 'DESC']);

        $annual_leave = $annual_leave->getEmployees();

        dd($annual_leave);

        #return $this->render('index.html.twig');

    }

    

    #[Route('/annual/leaves/create', name: 'create_annual_leave')]
    public function create(): Response
    {
        $annualLeave = new AnnualLeave();
        $form = $this->createForm(AnnualLeaveFormType::class, $annualLeave); 
        $newannualLeave = $form->getData();
        
        dd($new_annual_leave);
     
        $this->em->persist($new_annual_leave);
        $this->em->flush();

        return $this->render('annual/leaves');
    }

    #[Route('/annual/leaves/edit/{id}', name: 'edit_annual_leave')]
    public function edit($id): Response
    {
        $annualLeave = $this->annualLeaveRepository->find($id);
        $form = $this->createForm(AnnualLeaveFormType::class, $annualLeave);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annualLeave->setTypeOfLeave($form->get('typeOfLeave')->getData());
            $annualLeave->setStartDate($form->get('startDate')->getData());
            $annualLeave->setEndDate($form->get('endDate')->getData());

            $this->em->flush();
            return $this->redirectToRoute('annual/leaves');
        }

        return $this->render('annual/leaves/edit.html.twig',[
            'annualLeave' => $annualLeave,
            'form' => $form->createView()
        ]);
    }

    #[Route('/annual/leaves/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_annual_leave')]
    public function delete($id): Response
    {
        $annualLeave = $this->annualLeaveRepository->find($id);
        $this->em->remove($annualLeave);
        $this->em->flush();
        
        return $this->redirectToRoute('annual/leaves');
    }
}
