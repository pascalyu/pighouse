<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sampleTest
 *
 * @author Yu-Pa
 */
use PHPUnit\Framework\TestCase;

class sampleTest extends TestCase {

    public function testtest() {

        $this->assertEquals(42, 42);
        $this->assertEquals(42, "azeae");
    }

}
