<?php

namespace App\Tests\TestCase;

use App\Entity\Contacts;
use App\Entity\User;

final class ContactCreationTest extends DatabaseTestCase
{

    public function testContactcreation(): void
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
    public function testUsercreation(): void
    {
        $user = $this->insertUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertIsString($user->getFirstname());
        $this->assertIsString($user->getLastname());
        $this->assertIsString($user->getEmail());
        $this->assertIsString($user->getUsername());
        $this->assertIsArray($user->getRoles());
        $plainPassword = 'SIVA@123';
        $isPasswordValid = $this->encoder->isPasswordValid($user, $plainPassword);
        $this->assertTrue($isPasswordValid);
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
    public function insertUser()
    {

        $user = new User();
        $user->setUsername("test@2021");
        $user->setFirstName('test');
        $user->setLastName('user');
        $user->setEmail('testuser@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $plainPassword = 'SIVA@123';
        $encodedPassword = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }
}