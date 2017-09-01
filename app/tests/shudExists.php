<?php
class testExists extends TestCase {

    public function testUserCats()
    {
    	// if($user->god)
    	// $bool =True;
    	$user = Auth::user()->get();
        $this->assertTrue($user->god);
        // $this->call('post','decayHandle');
    }
    public function testLandPurchases()
    {
    	// if($user->god)
    	// $bool =True;
    	$user = Auth::user()->get();
    	$lands= $user->farmer->lands;
    	foreach ($lands as $land) {
	        $this->assertTrue($land->purchase);
    	}
    		# code...
        // $this->call('post','decayHandle');
    }

}