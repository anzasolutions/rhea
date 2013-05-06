<?php

namespace pl\anzasolutions\github\util;

class BranchUtilTest extends \PHPUnit_Framework_TestCase
{
    private $file;

    protected function setUp()
    {
        $this->file = dirname(__FILE__) . '/branch';
        touch($this->file);
        file_put_contents($this->file, 'ref: refs/heads/master');
    }

    /**
     * @test
     */
    public function currentBranchIsFoundProperly()
    {
        $expected = 'master';

        $actual = BranchUtil::getCurrent($this->file);

        $this->assertEquals($expected, $actual);
    }

    protected function tearDown()
    {
        unlink($this->file);
    }
}

?>