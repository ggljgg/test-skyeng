<?php
namespace Task3\tests\tests;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function testSimple()
    {
        $this->assertEquals('18', sum_strings('3', '15'));
    }

    public function testVeryBig()
    {
        $this->assertEquals('9223372036854775810', sum_strings('9223372036854775807', '3'));
        $this->assertEquals('92233720368547758070000000000003', sum_strings('92233720368547758070000000000000', '3'));
    }
}
