<?php


namespace FreedomSex\PhotoUploadBundle\Tests;


use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseTestSetUp extends KernelTestCase
{
    /** @var RequestStack */
    private $requestStack;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function get($id)
    {
        return self::$kernel->getContainer()->get($id);
    }

    public function param($name)
    {
        return self::$kernel->getContainer()->getParameter($name);
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $request = new Request();
        $request->server->set('REMOTE_ADDR', '123.123.12.1');
        $this->requestStack = $this->get('request_stack');
        $this->requestStack->push($request);

        $this->connection = $this->get('doctrine.dbal.default_connection');
        $this->entityManager = $this->get('doctrine');
    }

}