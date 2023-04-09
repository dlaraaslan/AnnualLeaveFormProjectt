<?php

namespace App\DataFixtures;

use App\Entity\AnnualLeave;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnnualLeaveFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $annualLeave = New AnnualLeave();
        $annualLeave->setTypeOfLeave("Sick Leave");
        $annualLeave->setStartDate(new \DateTime('2023-04-04'));
        $annualLeave->setEndDate(new \DateTime('2023-04-06'));
        $annualLeave->setCreatedAt(new \DateTimeImmutable('2023-04-04'));
        $annualLeave->setUpdatedAt(new \DateTime('2023-04-04'));
        $manager->persist($annualLeave);

        $annualLeave1 = New AnnualLeave();
        $annualLeave1->setTypeOfLeave("Casual Leave");
        $annualLeave1->setStartDate(new \DateTime('2023-04-06'));
        $annualLeave1->setEndDate(new \DateTime('2023-04-07'));
        $annualLeave1->setCreatedAt(new \DateTimeImmutable('2023-04-06'));
        $annualLeave1->setUpdatedAt(new \DateTime('2023-04-06'));
        $manager->persist($annualLeave1);

        $manager->flush();

        $this->addReference('annual_leave', $annualLeave);
        $this->addReference('annual_leave_1', $annualLeave1);

    }
}
