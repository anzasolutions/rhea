<?php

namespace core\util;

class HashGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->text = 'textToHash';
    }
    
    /**
     * @test
     */
    public function generateMD5AsExpected()
    {
        $expected = 'd5916e39bffde9aad31170af28b2f8d8';

        $actual = HashGenerator::generate(HashGenerator::MD5, $this->text);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateMD5ForNullGiveDefaultHash()
    {
        $expected = 'd41d8cd98f00b204e9800998ecf8427e';

        $actual = HashGenerator::generate(HashGenerator::MD5, null);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateMD5ForEmptyStringGiveDefaultHash()
    {
        $expected = 'd41d8cd98f00b204e9800998ecf8427e';

        $actual = HashGenerator::generate(HashGenerator::MD5, '');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA1AsExpected()
    {
        $expected = 'b7dcc42a736fc1fd0c386c884de1f4fbca7c403d';

        $actual = HashGenerator::generate(HashGenerator::SHA1, $this->text);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA1ForNullGiveDefaultHash()
    {
        $expected = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

        $actual = HashGenerator::generate(HashGenerator::SHA1, null);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA1ForEmptyStringGiveDefaultHash()
    {
        $expected = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

        $actual = HashGenerator::generate(HashGenerator::SHA1, '');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA256AsExpected()
    {
        $expected = '7f4dc0b7b6ee29343da0e63427e2feaf33e10f1cf161535b5239c54e9e3d19f0';

        $actual = HashGenerator::generate(HashGenerator::SHA256, $this->text);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA256ForNullGiveDefaultHash()
    {
        $expected = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';

        $actual = HashGenerator::generate(HashGenerator::SHA256, null);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA256ForEmptyStringGiveDefaultHash()
    {
        $expected = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';

        $actual = HashGenerator::generate(HashGenerator::SHA256, '');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA512AsExpected()
    {
        $expected = '96486caebe09179e8c1dac469dc513979fa6c235de44ef45fdc3c7e25d7f4d73e33d9a7aa4a1121780fd9bf026457ad2d085b6f929a3714e659db62f69313072';

        $actual = HashGenerator::generate(HashGenerator::SHA512, $this->text);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA512ForNullGiveDefaultHash()
    {
        $expected = 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e';

        $actual = HashGenerator::generate(HashGenerator::SHA512, null);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function generateSHA512ForEmptyStringGiveDefaultHash()
    {
        $expected = 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e';

        $actual = HashGenerator::generate(HashGenerator::SHA512, '');

        $this->assertEquals($expected, $actual);
    }
}

?>