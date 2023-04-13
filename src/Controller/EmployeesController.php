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


    #[Route('/check-leave')]
    public function checkAnnualLeaves(EntityManagerInterface $em): Response
    {
        $startDate = new \DateTime('2023-04-04');
        $endDate = new \DateTime('2023-04-06');

        $qb = $em->createQueryBuilder();
        $qb->select('a')
            ->from(AnnualLeave::class, 'a')
            ->join('a.employee', 'e')
            ->where('e.name LIKE :name')
            ->andWhere('e.surname LIKE :surname')
            ->andWhere('a.startDate <= :endDate')
            ->andWhere('a.endDate >= :startDate')
            ->setParameters([
                'name' => '%Dilara%', 
                'surname' => '%Kaya%', 
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

        $annualLeaves = $qb->getQuery()->getResult();

        if(count($annualLeaves) > 0) {
            return new Response('Personel izinli');
        } else {
            return new Response('Personel izinli değil');
        }
    }

    #[Route('/employee/{id}/{date}', methods: ['GET'], name: 'find_employee')]
    public function checkLeaveStatus($id, $date): Response
    {
        $annuaLeaveRepository = $this->em->getRepository(AnnualLeave::class);

        $employee = $this->employeeRepository->find($id);

        $annuaLeaves = $annuaLeaveRepository->findBy(['employee' => $employee]);

        foreach ($annuaLeaves as $leave) {
            $startDate = $leave->getStartDate()->format('Y-m-d');
            $endDate = $leave->getEndDate()->format('Y-m-d');
            if ($date >= $startDate && $date <= $endDate) {
                dd("izinli");
            }
        }
        dd("izinli değil");
    }

    #[Route('/employees-leave-status', methods: ['GET'])]
    public function employeeLeaveStatus(): Response
    {
        $startDate = new \DateTime('2023-05-01');
        $endDate = new \DateTime('2023-05-31');

        $employees = $this->employeeRepository->findAll();

        $results = [];
        foreach ($employees as $employee) {
            $annualLeaves = $employee->getAnnualLeaves();
            $leaveStatus = false;
            foreach ($annualLeaves as $annualLeave) {
                if ($annualLeave->getStartDate() <= $endDate && $annualLeave->getEndDate() >= $startDate) {
                    $leaveStatus = true;
                    break;
                }
            }
            $results[] = [
                'name' => $employee->getName() . ' ' . $employee->getSurname(),
                'leave_status' => $leaveStatus ? 'izinli' : 'izinli değil'
            ];
        }
        return $this->json($results);
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
