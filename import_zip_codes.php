<?php
/**
* ZipCode Import Task for Laravel (http://www.laravel.com)
* Written by: Steve Birstok (Nov. 12, 2012)
* http://www.stevebirstok.com/
* http://github.com/haykuro/
*
* For help visit:
* http://laravel.com/docs/artisan/tasks#creating-tasks
*
*/
class Import_Zip_Codes_Task
{
	public static $zipcode_url = 'http://download.geonames.org/export/zip/US.zip';

	public function __construct()
	{
		$this->zipcode_archive = path('storage').'zipcodes/US.zip';
		$this->zipcode_path = path('storage').'zipcodes/US.txt';
	}

	public function download_latest()
	{
		if(File::exists($this->zipcode_archive))
		{
			File::delete($this->zipcode_archive);
		}

		if( ! $handle = fopen('http://download.geonames.org/export/zip/US.zip', 'r') )
		{
			throw new Exception('Could not download latest ZipCode file.');
		}

		$content = stream_get_contents($handle);
		fclose($handle);
		return File::put($this->zipcode_archive, $content);
	}

	private function get_line($text)
	{
		if(strlen($text) < 1)
		{
			return false;
		}
		$line = explode("\t", $text);
		$array = array(
			'country_code' => $line[0],
			'postal_code' => $line[1],
			'place_name' => $line[2],
			'admin_name1' => $line[3],
			'admin_code1' => $line[4],
			'admin_name2' => $line[5],
			'admin_code2' => $line[6],
			'admin_name3' => $line[7],
			'admin_code3' => $line[8],
			'latitude' => $line[9],
			'longitude' => $line[10],
			'accuracy' => $line[11],
		);

		return $array;
	}

	public function run($args)
	{
		echo '[.] Adding zipcodes to Database... ';
		$content = file_get_contents($this->zipcode_path);
		$lines = explode("\n", $content);
		$i = 0;
		foreach($lines as $line)
		{
			$info = $this->get_line($line);
			if($info !== false)
			{
				$zip = ZipCode::create($info);
			}
		}
		echo '[DONE]';
		return;
	}
}