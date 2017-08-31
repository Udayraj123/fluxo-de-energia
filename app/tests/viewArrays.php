<?php
class FooTest extends TestCase {

  public function testMethod()
    {
        $this->call('GET', '/');
        $this->assertViewHas('name');
        $this->assertViewHas('age', 12);
    }
}