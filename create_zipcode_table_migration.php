<?php
/*
* Written by: Steve Birstok
* for help visit: http://laravel.com/docs/database/migrations#running-migrations
*
*/
class Create_Zipcode_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
			country code      : iso country code, 2 characters
			postal code       : varchar(20)
			place name        : varchar(180)
			admin name1       : 1. order subdivision (state) varchar(100)
			admin code1       : 1. order subdivision (state) varchar(20)
			admin name2       : 2. order subdivision (county/province) varchar(100)
			admin code2       : 2. order subdivision (county/province) varchar(20)
			admin name3       : 3. order subdivision (community) varchar(100)
			admin code3       : 3. order subdivision (community) varchar(20)
			latitude          : estimated latitude (wgs84)
			longitude         : estimated longitude (wgs84)
			accuracy          : accuracy of lat/lng from 1=estimated to 6=centroid

		*/
		Schema::table('zipcodes', function($table)
		{
			$table->create();
			$table->increments('id')->unsigned();
			$table->string('country_code', 2);
			$table->string('postal_code', 20)->index();
			$table->string('place_name', 180);
			$table->string('admin_name1', 100);
			$table->string('admin_code1', 20);
			$table->string('admin_name2', 100);
			$table->string('admin_code2', 20);
			$table->string('admin_name3', 100);
			$table->string('admin_code3', 20);
			$table->decimal('latitude', 10, 2);
			$table->decimal('longitude', 10, 2);
			$table->integer('accuracy');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zipcodes');
	}

}