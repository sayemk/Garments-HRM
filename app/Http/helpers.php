<?php 

function magentCall(\GuzzleHttp\Client $client, $query = null)
{
	if (is_null($query)) {
		return 0;
	}
	$response = $client->request('GET', $query, [
            'headers' => [
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer '.env('MAGENTO_TOKEN')
            ]

        ]);
	return json_decode($response->getBody()->getContents());
}

function getMagentoCategoryByID(\GuzzleHttp\Client $client, $query = null)
{
		
	$category = magentCall($client, $query);

	$generatedArray['id'] = $category->id;
	$generatedArray['name'] = $category->name;
	$generatedArray['parent_id'] = $category->parent_id;
	$generatedArray['created_at'] = $category->created_at;
	$generatedArray['updated_at'] = $category->updated_at;
	$generatedArray['children'] = $category->children;

	return $generatedArray;

	
}
$GLOBALS['categories'] = [];
function getMagentoCategories(\GuzzleHttp\Client $client, $query = null)
{
	//$categories[] = $categories;

	$category = getMagentoCategoryByID($client, $query);
	$GLOBALS['categories'][] = $category;
	//echo "<pre>";
	if (!is_null($category['children'])) {
		$childrens = array_filter(explode(',',$category['children']));
		 //print_r($category);
		
		 //exit('H');
		if (!empty($childrens)) {
			foreach ($childrens as $child) {
				getMagentoCategories($client, 'categories/'.$child);
			}
		}
	}

	return $GLOBALS['categories'];
}


function getProductCustomAtribute(stdClass $product , $search)
{
	$customAttributes = $product->custom_attributes;
	foreach ($customAttributes as $attribute) {
		if (trim($attribute->attribute_code) == $search) {
			return $attribute->value;
		}
	}
	return false;
}

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

