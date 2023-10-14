<?php

namespace App\Tests\TestCase;

use App\Entity\Contacts;

final class ContactCreationTest extends DatabaseTestCase
{

    public function testFindDefault(): void
    {
        $contact = $this->insertContact();
        $this->assertInstanceOf(Contacts::class, $contact);
        $this->assertIsString($contact->getFirstname());
        $this->assertEquals('Test', $contact->getFirstname());
        $this->assertEquals('contact', $contact->getLastName());
        $this->assertEquals('testcontact@gmail.com', $contact->getEmail());
        $this->assertEquals('2452345423', $contact->getContactnumber());
        $this->assertEquals('chennai', $contact->getAddress());
        $this->assertIsString('contact', $contact->getLastName());
        $this->assertIsString('testcontact@gmail.com', $contact->getEmail());
        $this->assertIsString('2452345423', $contact->getContactnumber());
        $this->assertIsString('chennai', $contact->getAddress());
    }

    public function insertContact()
    {
        $contact = new Contacts();
        $contact->setTitle('Mr');
        $contact->setFirstname('Test');
        $contact->setLastname('contact');
        $contact->setEmail('testcontact@gmail.com');
        $contact->setContactnumber('2452345423');
        $contact->setaddress('chennai');
        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $contact;
    }
}