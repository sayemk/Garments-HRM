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

function durationCalc($inTime, $outTime){
	$inTime = \Carbon\Carbon::createFromFormat("H:i:s",$inTime);
	$outTime = \Carbon\Carbon::createFromFormat("H:i:s",$outTime);

	$seconds = $inTime->diffInSeconds($outTime);

	return gmdate("H:i:s",$seconds);
}

function overtimeCalc($duration, $officeHour){
	$duration = explode(":",$duration);

	if ($duration[0] >= $officeHour){
		$hour = $duration[0] - $officeHour;

		return "$hour:$duration[1]:$duration[2]";
	}else{
		return "00:00:00";
	}
}

function lateTimeCalc($inTime, $bufferTime)
{
	$inTime = strtotime($inTime);

	$bufferTime = strtotime($bufferTime);

	$late = $inTime-$bufferTime;


	if ($late>0){
		return gmdate("H:i:s",$late);
	}else {
		return "00:00:00";
	}


}

function spanClass($flag)
{
	return ($flag)? 'text-green' : 'text-danger';
}

function uploadMessage($flag){
	return ($flag)? 'Success' : 'Failed';
}

/**
 * @return array
 */
function months(){
	return [
		''=>'Select Month',
		'1'=>'Jan',
		'2'=>'Feb',
		'3'=>'Mar',
		'4'=>'Apr',
		'5'=>'May',
		'6'=>'Jun',
		'7'=>'Jul',
		'8'=>'Aug',
		'9'=>'Sep',
		'10'=>'Oct',
		'11'=>'Nov',
		'12'=>'Dec'
	];
}



