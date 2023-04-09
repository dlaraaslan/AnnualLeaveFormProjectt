<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $employee = new Employee();
        $employee->setName('Dilara');
        $employee->setSurname('Kaya');
        $employee->setStartDateOfWork(new \DateTime('2021-12-01'));
        $employee->setRegisterNo('1111111');
        $employee->setIndentityNumber('11111111111');
        $employee->setCreatedAt(new \DateTimeImmutable('2023-04-08'));
        $employee->setUpdatedAt(new \DateTime('2023-04-08'));

        $employee->addAnnualLeave($this->getReference('annual_leave'));
        $manager->persist($employee);

        $employee2 = new Employee();
        $employee2->setName('Ali');
        $employee2->setSurname('Can');
        $employee2->setStartDateOfWork(new \DateTime('2022-12-01'));
        $employee2->setRegisterNo('1111112');
        $employee2->setIndentityNumber('11111111112');
        $employee2->setCreatedAt(new \DateTimeImmutable('2023-04-08'));
        $employee2->setUpdatedAt(new \DateTime('2023-04-08'));

        $employee->addAnnualLeave($this->getReference('annual_leave_1'));
        $manager->persist($employee2);

        $manager->flush();

    }
}
