<?php 

function checkPermission($resource)
{
	$user_permissions = \Auth::user()->role->permissions->keyBy('resource');
	return ($user_permissions->has($resource)) ? true : false;
}

function gmtToBDTime($gmt)
{
	$date = new DateTime($gmt);
	$date->setTimezone(new DateTimeZone('Asia/Dhaka')); // +04

	return $date->format('d-m-Y h:i:s A'); 
}

function getCountryName(\GuzzleHttp\Client $client, $countryCode)
{
	$country = magentCall($client, 'directory/countries/'.$countryCode);

	return $country->full_name_english;
}

function getDaysInaYear($year,$day ='Friday', $format, $timezone='Asia/Dhaka')
{
	$fridays = array();
    $startDate = new DateTime("{$year}-01-01 $day", new DateTimezone($timezone));
    $year++;
    $endDate = new DateTime("{$year}-01-01", new DateTimezone($timezone));
    $int = new DateInterval('P7D');
    foreach(new DatePeriod($startDate, $int, $endDate) as $d) {
        $fridays[]['date'] = $d->format($format);
    }

    return $fridays;
}


function employeeStatus($status)
{
	if ($status == 1) {
		return "Active";
	} else if ($status == 2) {
		return 'New';
	} else {
		return 'Inactive';
	}

}
function leavePayable($flag)
{
	return ($flag) ? 'Yes' : 'No';

}

