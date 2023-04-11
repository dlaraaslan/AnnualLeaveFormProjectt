<?php

namespace App\Controller; 
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesController extends AbstractController
{
    private $employeeRepository;
    public function __construct(EmployeeRepository $employeeRepository, EntityManagerInterface $em)
    {
       $this->employeeRepository = $employeeRepository;
       $this->em = $em;
    }

    #[Route('/employee/{name}-{surname}', methods: ['GET'], name: 'show_employee')]
    public function show($name, $surname): Response
    {
        $employee = $this->employeeRepository->findOneBy(['name' => $name, 'surname' => $surname], ['id' => 'DESC']);
        $employee = $employee->getAnnualLeaves();

        dd($employee);

        #return $this->render('index.html.twig');
    }


    #[Route('/employees', methods: ['GET'], name: 'employees')]
    public function index(): Response
    {
        $employees = $this->employeeRepository->findAll();
        dd($employees);

        #return $this->render('index.html.twig');
    }

    #[Route('/employees/create', name: 'create_employee')]
    public function create(): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeFormType::class, $employee);
        $newEmployee = $form->getData();
        
        dd($new_employee);
        // return $this->render('movie/create.html.twig', [
        //     'form' => $form->createView()
        // ]);

        $this->em->persist($newEmployee);
        $this->em->flush();

        return $this->render('employees');
    }

    #[Route('/employees/edit/{id}', name: 'edit_employee')]
    public function edit($id): Response
    {
        $employee = $this->employeeRepository->find($id);
        $form = $this->createForm(EmployeeFormType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee->setName($form->get('name')->getData());
            $employee->setSurname($form->get('surname')->getData());
            $employee->setStartDateOfWork($form->get('startDateOfWork')->getData());
            $employee->setDateOfDismissal($form->get('dateOfDismissal')->getData());
            $employee->setRegisterNo($form->get('registerNo')->getData());
            $employee->setIndentityNumber($form->get('indentityNumber')->getData());

            $this->em->flush();
            return $this->redirectToRoute('employees');
        }

        return $this->render('employees/edit.html.twig',[
            'employee' => $employee,
            'form' => $form->createView()
        ]);
    }


    #[Route('/employees/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_employee')]
    public function delete($id): Response
    {
        $employee = $this->employeeRepository->find($id);
        $this->em->remove($employee);
        $this->em->flush();
        
        return $this->redirectToRoute('employees');
    }


}
