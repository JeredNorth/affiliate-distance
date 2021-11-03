<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use View;
use File;

class affiliateController extends Controller {


	public function affiliateView() {

		//The GPS coordinates for our Dublin office are 53.3340285, -6.2535495.

		$affiliatesFile = file(storage_path('app\public\affiliates.txt'));

		$affiliates = [];

		foreach($affiliatesFile as $line) { //make sure that it's formatted correctly and put the lines in the affiliates array
			array_push($affiliates, json_decode($line));
		}

		$lat = 53.3340285; //Starting latitude
		$lon = -6.2535495; //Starting longitude
		$distance = 100; //Distance in KM
		$R = 6371; //constant earth radius. You can add precision here if you wish
		
		$maxLat = $lat + rad2deg($distance/$R); //54.233350105919
		$minLat = $lat - rad2deg($distance/$R); //52.434706894081
		$maxLon = $lon + rad2deg(asin($distance/$R) / cos(deg2rad($lat))); //-4.7474618251589
		$minLon = $lon - rad2deg(asin($distance/$R) / cos(deg2rad($lat))); //-7.7596371748411
		

		$filteredAffiliates = [];

		foreach ($affiliates as $affiliate) { //check against the longitude and latitude of the affiliates and push only if the lon/lat are within the min/max
			if($affiliate->latitude < $maxLat && $affiliate->latitude > $minLat && $affiliate->longitude < $maxLon && $affiliate->longitude > $minLon) {
				array_push($filteredAffiliates, $affiliate);
			}
			else {
				continue;
			}
		}


		$keys = array_column($filteredAffiliates, 'affiliate_id'); //order the affiliates by affiliate_id
		array_multisort($keys, SORT_ASC, $filteredAffiliates);


		return View::make('welcome')->with('affiliates', $filteredAffiliates);
	}

}
