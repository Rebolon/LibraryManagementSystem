<?php

namespace App\Tests\Repository;

use App\Entity\Library\Book;
use App\Entity\Library\Loan;
use App\Entity\Library\Reader;
use App\Tests\Common\TestCaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReaderRepositoryTest extends KernelTestCase
{
    use TestCaseTrait;

    public function testWhoBorrowBook()
    {
        $this->markTestIncomplete();
    }

    public function testWhoLoanBook()
    {
        $this->markTestIncomplete();
    }
}
