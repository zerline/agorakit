<?php

use App\Group;

class GeocodeTest extends Tests\BrowserKitTestCase
{
    /******************* Why is it done this way ? ***************/

    /*
    I want my tests runs on a clean DB, and each test in the right order, like I would do by hand.
    The first tests migrates the testing DB
    Sounds simplier like this for me, I don't want the database being remigrated after each test.
    Only after the whole suite has been run.

    You need a agorakit_testing DB available for those tests to run.


    Our scenario :

    - we have admin, our admin
    - we also have Newbie, another user

    - Roberto creates 2 groups, an open one and a closed one
    - Newbie tries to join both

    What happens ?


    */

    /* tests starts here : let's setup the DB
    */
    public function testSetupItAll()
    {
        Artisan::call('migrate:refresh');

        $this->visit('/')
            ->see('Agorakit');
    }

    /**
     * Register our first user.
     */
    public function testUserRegistration()
    {
        Mail::fake();

        $this->visit('/register')
            ->type('Admin', 'name')
            ->type('admin@agorakit.org', 'email')
            ->press('Register')
            ->type('123456789', 'password')
            ->type('123456789', 'password_confirmation')
            ->press('Register')
            ->see('Agorakit');

        $this->seeInDatabase('users', ['email' => 'admin@agorakit.org']);
    }

    public function testGroupCreation()
    {
        $user = App\User::where('email', 'admin@agorakit.org')->first();

        $user->confirmEmail();

        $this->actingAs($user)
            ->visit('groups/create')
            ->see('Create a new group')
            ->type('Test group for geocoding', 'name')
            ->type('this is a test group for geocoding tests', 'body')
            ->type('Bagneux', 'address')
            ->press('Create the group')
            ->see('Test group for geocoding');
    }

    public function testGroupCoordinates()
    {
    	 $group = App\Group::where('name', 'Test group for geocoding')->first();
	 $this->assertTrue ($group->latitude > 0);
	 $this->assertTrue ($group->longitude > 0);
    } 
}
