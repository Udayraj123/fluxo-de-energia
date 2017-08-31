<?php
class testUserCats extends TestCase {

    public function testSomethingIsTrue()
    {
    	// if($user->god)
    	// $bool =True;
    	$user = Auth::user()->get();
        $this->assertTrue($user->god);
        // $this->call('post','decayHandle');
    }

}