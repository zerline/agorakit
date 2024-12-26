<?php

use Illuminate\Database\Migrations\Migration;

class AddAddressSpecificationsToGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function ($table) {
            $table->string('countrycode', length:7);  
            $table->string('postalcodeorcounty'); // Keep it flexible
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function ($table) {
            $table->dropColumn('countrycode');
            $table->dropColumn('postalcodeorcounty');
        });
    }
}
