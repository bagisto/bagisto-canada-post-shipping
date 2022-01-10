<?php

namespace Webkul\CanadaPost\Helpers;

class ApiHelper
{
    public function calculateShipppingRate($postalCode, $weight, $serviceCode, $countryCode)
    {
        $data = array();
        $username = core()->getConfigData('sales.carriers.canadapost.api_userid');
        $password = core()->getConfigData('sales.carriers.canadapost.api_password');
        $mailedBy = core()->getConfigData('sales.carriers.canadapost.client_number');
        $quoteType = core()->getConfigData('sales.carriers.canadapost.rate_type');
        $agreementType = core()->getConfigData('sales.carriers.canadapost.agreement_type');
        $contractId = core()->getConfigData('sales.carriers.canadapost.agreement_number');
        $mode = core()->getConfigData('sales.carriers.canadapost.cp_mode');
        $weightType = core()->getConfigData('sales.carriers.canadapost.weight_unit');
        $isCalculateTax = core()->getConfigData('sales.carriers.canadapost.is_calculate_tax');

        // REST URL
        if ($mode == 'development') {
            $service_url = 'https://ct.soa-gw.canadapost.ca/rs/ship/price';
        } else {
            $service_url = 'https://soa-gw.canadapost.ca/rs/ship/price';
        }

        if ($weightType == 'pounds') {
            $weight = round((0.453592 * $weight), 3);
        } 

        if ($weight == 0) {
            return false;
        }
        
        if (core()->getConfigData('sales.carriers.canadapost.active')) {
            // Create GetRates request xml
            $originPostalCode = core()->getConfigData('sales.shipping.origin.zipcode');

            if ($countryCode == "CA") {

                if ($quoteType == 'counter') {
                    $xmlRequest = <<<XML
                    <?xml version="1.0" encoding="UTF-8"?>
                    <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                    <quote-type>{$quoteType}</quote-type>
                    <parcel-characteristics>
                        <weight>{$weight}</weight>
                    </parcel-characteristics>
                    <services>
                        <service-code>{$serviceCode}</service-code>
                    </services>
                    <origin-postal-code>{$originPostalCode}</origin-postal-code>
                    <destination>
                        <domestic>
                        <postal-code>{$postalCode}</postal-code>
                        </domestic>
                    </destination>
                    </mailing-scenario>
                    XML;
                }
                else {
                    if ($agreementType == 'non_contract') {
                        $xmlRequest = <<<XML
                        <?xml version="1.0" encoding="UTF-8"?>
                        <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                        <customer-number>{$mailedBy}</customer-number>
                        <quote-type>{$quoteType}</quote-type>
                        <parcel-characteristics>
                            <weight>{$weight}</weight>
                        </parcel-characteristics>
                        <services>
                            <service-code>{$serviceCode}</service-code>
                        </services>
                        <origin-postal-code>{$originPostalCode}</origin-postal-code>
                        <destination>
                            <domestic>
                            <postal-code>{$postalCode}</postal-code>
                            </domestic>
                        </destination>
                        </mailing-scenario>
                        XML;
                    } else {
                        $xmlRequest = <<<XML
                        <?xml version="1.0" encoding="UTF-8"?>
                        <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                        <customer-number>{$mailedBy}</customer-number>
                        <contract-id>{$contractId}</contract-id>
                        <quote-type>{$quoteType}</quote-type>
                        <parcel-characteristics>
                            <weight>{$weight}</weight>
                        </parcel-characteristics>
                        <services>
                            <service-code>{$serviceCode}</service-code>
                        </services>
                        <origin-postal-code>{$originPostalCode}</origin-postal-code>
                        <destination>
                            <domestic>
                            <postal-code>{$postalCode}</postal-code>
                            </domestic>
                        </destination>
                        </mailing-scenario>
                        XML;
                    } 
                }
            }
            elseif ($countryCode == "US") {

                if ($quoteType == 'counter') {
                    $xmlRequest = <<<XML
                    <?xml version="1.0" encoding="UTF-8"?>
                    <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                    <quote-type>{$quoteType}</quote-type>
                    <parcel-characteristics>
                        <weight>{$weight}</weight>
                    </parcel-characteristics>
                    <services>
                        <service-code>{$serviceCode}</service-code>
                    </services>
                    <origin-postal-code>{$originPostalCode}</origin-postal-code>
                    <destination>
                        <united-states>
                        <zip-code>{$postalCode}</zip-code>
                        </united-states>
                    </destination>
                    </mailing-scenario>
                    XML;
                } else {

                    if ($agreementType == 'non_contract') {
                        $xmlRequest = <<<XML
                        <?xml version="1.0" encoding="UTF-8"?>
                        <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                        <customer-number>{$mailedBy}</customer-number>
                        <quote-type>{$quoteType}</quote-type>
                        <parcel-characteristics>
                            <weight>{$weight}</weight>
                        </parcel-characteristics>
                        <services>
                            <service-code>{$serviceCode}</service-code>
                        </services>
                        <origin-postal-code>{$originPostalCode}</origin-postal-code>
                        <destination>
                            <united-states>
                            <zip-code>{$postalCode}</zip-code>
                            </united-states>
                        </destination>
                        </mailing-scenario>
                        XML;
                    } else {
                        $xmlRequest = <<<XML
                        <?xml version="1.0" encoding="UTF-8"?>
                        <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                        <customer-number>{$mailedBy}</customer-number>
                        <contract-id>{$contractId}</contract-id>
                        <quote-type>{$quoteType}</quote-type>
                        <parcel-characteristics>
                            <weight>{$weight}</weight>
                        </parcel-characteristics>
                        <services>
                            <service-code>{$serviceCode}</service-code>
                        </services>
                        <origin-postal-code>{$originPostalCode}</origin-postal-code>
                        <destination>
                            <united-states>
                            <zip-code>{$postalCode}</zip-code>
                            </united-states>
                        </destination>
                        </mailing-scenario>
                        XML;
                    } 
                }
            }
            else {

                if ($quoteType == 'counter') {
                    $xmlRequest = <<<XML
                    <?xml version="1.0" encoding="UTF-8"?>
                    <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                    <quote-type>{$quoteType}</quote-type>
                    <parcel-characteristics>
                        <weight>{$weight}</weight>
                    </parcel-characteristics>
                    <services>
                        <service-code>{$serviceCode}</service-code>
                    </services>
                    <origin-postal-code>{$originPostalCode}</origin-postal-code>
                    <destination>
                        <international>
                        <country-code>{$countryCode}</country-code>
                        <postal-code>{$postalCode}</postal-code>
                        </international>
                    </destination>
                    </mailing-scenario>
                    XML;
                } else {
                    if ($agreementType == 'non_contract') {
                        $xmlRequest = <<<XML
                        <?xml version="1.0" encoding="UTF-8"?>
                        <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                        <customer-number>{$mailedBy}</customer-number>
                        <quote-type>{$quoteType}</quote-type>
                        <parcel-characteristics>
                            <weight>{$weight}</weight>
                        </parcel-characteristics>
                        <services>
                            <service-code>{$serviceCode}</service-code>
                        </services>
                        <origin-postal-code>{$originPostalCode}</origin-postal-code>
                        <destination>
                            <international>
                            <country-code>{$countryCode}</country-code>
                            <postal-code>{$postalCode}</postal-code>
                            </international>
                        </destination>
                        </mailing-scenario>
                        XML;
                    } else {
                        $xmlRequest = <<<XML
                        <?xml version="1.0" encoding="UTF-8"?>
                        <mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v4">
                        <customer-number>{$mailedBy}</customer-number>
                        <contract-id>{$contractId}</contract-id>
                        <quote-type>{$quoteType}</quote-type>
                        <parcel-characteristics>
                            <weight>{$weight}</weight>
                        </parcel-characteristics>
                        <services>
                            <service-code>{$serviceCode}</service-code>
                        </services>
                        <origin-postal-code>{$originPostalCode}</origin-postal-code>
                        <destination>
                            <international>
                            <country-code>{$countryCode}</country-code>
                            <postal-code>{$postalCode}</postal-code>
                            </international>
                        </destination>
                        </mailing-scenario>
                        XML;
                    }
                }               
                
            }
            
            $curl = curl_init($service_url); // Create REST Request
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . '/../Cert/cacert.pem');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlRequest);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.cpc.ship.rate-v4+xml', 'Accept: application/vnd.cpc.ship.rate-v4+xml'));
            $curl_response = curl_exec($curl); // Execute REST Request
            if(curl_errno($curl)){
                return false;
            }

            curl_close($curl);

            // Using SimpleXML to parse xml response
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string('<root>' . preg_replace('/<\?xml.*\?>/','',$curl_response) . '</root>');
            if (!$xml) {
                return false;
            } else {
                if ($xml->{'price-quotes'} ) {
                    $priceQuotes = $xml->{'price-quotes'}->children('http://www.canadapost.ca/ws/ship/rate-v4');
                    if ( $priceQuotes->{'price-quote'} ) {
                        foreach ( $priceQuotes as $priceQuote ) {  	
                            array_push($data, $priceQuote->{'price-details'}->{'due'});
                        }
                        
                        return $data;
                    }
                    else {
                        return false;
                    }
                }
                if ($xml->{'messages'} ) {					
                    return false;
                }
                    
            }
        }
        else {
            return false;
        }

    }

}