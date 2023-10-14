<?php

namespace App\Tests\TestCase;

use Doctrine\ORM\EntityManager;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

class DatabaseTestCase extends WebTestCase
{
    protected $entityManager;
    protected $application;

    public function setUp(): void
    {
        $this->checkEnvironment();

        $kernel = self::bootKernel();
        $this->encoder = self::$container->get('security.password_encoder');
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->runCommand('doctrine:database:drop --force');
        $this->runCommand('doctrine:database:create');
        $this->runCommand('doctrine:schema:create');
    }

    protected function checkEnvironment(): void
    {
        if ('test' !== $_ENV['APP_ENV']) {
            throw new LogicException('Execution only in the Test environment is possible!');
        }
    }

    protected function runCommand($command): int
    {
        $command = sprintf('%s --quiet', $command);
        return $this->getApplication()->run(new StringInput($command));
    }

    protected function getApplication(): Application
    {
        if (null === $this->application) {
            $this->application = new Application(static::$kernel);
            $this->application->setAutoExit(false);
        }

        return $this->application;
    }
}
