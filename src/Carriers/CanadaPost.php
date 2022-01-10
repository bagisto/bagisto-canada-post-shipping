<?php

namespace Webkul\CanadaPost\Carriers;

use Config;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Shipping\Carriers\AbstractShipping;
use Webkul\Checkout\Facades\Cart;

/**
 * Class Rate.
 *
 */
class CanadaPost extends AbstractShipping
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'canadapost';

    public function __construct()
    {
        $this->apiHelper =  app('Webkul\CanadaPost\Helpers\ApiHelper');
    }

    /**
     * Returns rate for Canada Post
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        
        if (! $this->isAvailable()) {
            
            return false;
        }
        
        $cart = Cart::getCart();

        $shippingpricedetails =  $this->findRates();

        if ($shippingpricedetails == false) {

            return false;
        }
        
        if(!count($shippingpricedetails)){

            return false;
            session()->flash('error', 'something went wrong');

		} else {

            $shippingMethods = [];

            foreach ($shippingpricedetails as $shippingpricedetail) {

                $result = new CartShippingRate;
                $result->carrier = $shippingpricedetail['code'];
                $result->carrier_title = $shippingpricedetail['name'];
                $result->method = $shippingpricedetail['code'];
                $result->method_title = $this->getConfigData('title');
                $result->method_description = $shippingpricedetail['name'];
                $result->is_calculate_tax = $this->getConfigData('is_calculate_tax');
                $result->price = core()->convertPrice($shippingpricedetail['price']);
                $result->base_price = $shippingpricedetail['price'];

                array_push($shippingMethods, $result);
            }

            return $shippingMethods;
        }
    }

    /**
     * Returns Canada Post shipment methods (depending on country)
     *
     * @return array
     */
    public function getShippingServices($countryCode)
    {
        $dom = [
            'DOM.RP'      => 'Regular Parcel',
            'DOM.EP'      => 'Expedited Parcel',
            'DOM.XP'      => 'Xpresspost',
            'DOM.XP.CERT' => 'Xpresspost Certified',
            'DOM.PC'      => 'Priority',
            'DOM.LIB'     => 'Library Materials'
        ];

        $usa = [
            'USA.EP'        => 'Expedited Parcel USA',
            'USA.PW.ENV'    => 'Priority Worldwide Envelope USA',
            'USA.PW.PAK'    => 'Priority Worldwide pak USA',
            'USA.PW.PARCEL' => 'Priority Worldwide Parcel USA',
            'USA.SP.AIR'    => 'Small Packet USA Air',
            'USA.TP'        => 'Tracked Packet – USA',
            'USA.TP.LVM'    => 'Tracked Packet – USA',
            'USA.XP'        => 'Xpresspost USA'
        ];

        $int = [
            'INT.XP'        => 'Xpresspost International',
            'INT.IP.AIR'    => 'International Parcel Air',
            'INT.IP.SURF'   => 'International Parcel Surface',
            'INT.PW.ENV'    => 'Priority Worldwide Envelope Int’l',
            'INT.PW.PAK'    => 'Priority Worldwide pak Int’l',
            'INT.PW.PARCEL' => 'Priority Worldwide parcel Int’l',
            'INT.SP.AIR'    => 'Small Packet International Air',
            'INT.SP.SURF'   => 'Small Packet International Surface',
            'INT.TP'        => 'Tracked Packet – International'
        ];

        if ($countryCode == 'CA') {
            // Domestic shipping
            return $dom;
        }
        if ($countryCode == 'US') {
            // USA shipping
            return $usa;
        } else {
            // International shipping
            return $int;
        }
    }

    /*
    * return the Canada Post shipping rates
    */
    public function findRates()
    {

        if(!core()->getConfigData('sales.carriers.canadapost.active')){
			 return false;
        }

        $cart = Cart::getCart();

        $price = 0;

        $postalCode = $cart->shipping_address->postcode;

        $countryCode = $cart->shipping_address->country;

        $allowedMethods = explode(",", core()->getConfigData('sales.carriers.canadapost.allowed_methods'));

        $shippingServices = $this->getShippingServices($countryCode);

        $shippingpricedetail = [];

        foreach ($shippingServices as $serviceCode => $shippingService) {
            if (in_array($serviceCode, $allowedMethods )) {

                $validCartItems = $this->getValidCartItems($cart->items()->get());

                foreach($validCartItems as $item) {

                    $shippingCharges = $this->apiHelper->calculateShipppingRate($postalCode, round($item->weight,3), $serviceCode ,$countryCode);

                    if ($item->product->getTypeInstance()->isStockable() && $shippingCharges) {
                        $price += $shippingCharges[0] * $item->quantity;
                    }
                }

                if($price) {
                    array_push($shippingpricedetail, array('name' => $shippingService, 'price' => $price, 'code' => $serviceCode));
                }                
            }
        }

        return $shippingpricedetail;
    }

    public function getValidCartItems($cartItems)
    {
        $validItems = [];

        foreach ($cartItems as $item) {
            if ($item->product->type != 'virtual' && $item->product->type != 'downloadable' && $item->product->type != 'booking') {

                array_push($validItems, $item);
            }
        }

        return $validItems;
    }
}
