# CAMEROON MOBILE MONEY PACKAGE FOR LARAVEL 

packages/ngambmicheal/mobilemoney

Mobile Money is payment service which you can integrate in your application to perform payment via Mobile Money providers like MTN Mobile Money and Orange Money

* Cameroon Mtn Mobile Money
* Cameroon Orange Money

## Quick Start

### App Key

Before using this Api, you must obtain a client key and secret key from Webshinobis. You contact us through our [website](http://api.webshinobis.com)

### Setup

Update your `composer.json` file and add the following under the `require` key

	"ngambmicheal/mobilemoney": "dev-master"

Run the composer update command:

	$ composer update

Or you can still run the command:

	$ composer require ngambmicheal/mobilemoney

In your `config/app.php` add `'Ngambmicheal\MobileMoney\MobileMoneyProvider'` to the end of the `$providers` array

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'Ngambmicheal\MobileMoney\MobileMoneyProvider',

    ),

Still under `config/app.php` add `'MobileMoney' => 'Ngambmicheal\MobileMoney\MobileMoney'` to the `$aliases` array

    'aliases' => array(

        'App'             => 'Illuminate\Support\Facades\App',
        'Artisan'         => 'Illuminate\Support\Facades\Artisan',
        ...
        'MobileMoney'           => 'Ngambmicheal\MobileMoney\MobileMoney',

    ),

Run the `artisan` command below to publish the configuration file

	$ php artisan vendor:publish

Navigate to `app/config/mobilemoney.php` and update all four parameters

### Config
 
 In the config/mobilemoney.php file

```php
    
return [
    
       ...

        /*  Your client key */
        'webshinobis_client_key'=>'',  //Change this to your client key

        /*  Your secret key */
        'webshinobis_secret_key'=>'', //Change this to your secret key

        /* Do you want your app to support MTN mobile services? 

        Default : true

        */
        'mtn_mobile_money'  =>  true,
];

```

### Examples


```php
// doing an mtn mobile money transaction;

use MobileMoney 

class MomoController extends controller {
    
    public function doMoMo($request){
        $phone = $request->phone;
        $price = $request->price;



        // do a mobile money transaction 

        $mobilemoney = new MobileMoney;
        $mobilemoney->phone = $phone;
        $mobilemoney->price = $price;
        
        $momo        = $mobilemoney->doMTNTransaction();

        if($momo->state){
            //transaction was successful

            return $momo; 

            /*
                $momo = (object) [
                    'transaction_id' => '12345678',
                    'state'          => true,
                    'status'         => 'success',
                    'message'        => 'Transaction Was successfull ...',
                    'phone'          => '237678140682',
                    'price'          => '1500'
                ];
            */
        }
        else{
            //transaction faile
                $momo = (object) [
                    'message'        => 'Transaction failed ...',
                    'state'          => false,
                    'status'         => 'failure'
                ];
        }
        
    }

} 



```

## License

Released under the MIT License, see [LICENSE](LICENSE).

## Aditional information

Any questions, feel free to contact me.

Any issues, please [report here](https://github.com/ngambmicheal/mobilemoney/issues)
