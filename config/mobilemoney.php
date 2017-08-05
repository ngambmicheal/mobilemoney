<?php 
	
	return [

		/*
			Before using this Api, you must obtain a client key and secret key from Webshinobis. You contact us through our website www.ngambmicheal@gmail.com
		*/

		/*	Your client key */
		'webshinobis_client_key'=>env('webshinobis_client_key',''),

		/*  Your secret key */
		'webshinobis_secret_key'=>env('webshinobis_secret_key',''),

		/* Do you want your app to support MTN mobile services? 

		Default : true

		*/
		'mtn_mobile_money'  =>  true,
		

	];