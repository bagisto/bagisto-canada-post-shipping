<?php

return [
    [
        'key'    => 'sales.carriers.canadapost',
        'name'   => 'canadapost::app.admin.system.canada-post-shipping',
        'sort'   => 3,
        'fields' => [
            [
                'name'          => 'active',
                'title'         => 'canadapost::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',                
            ], [
                'name'          => 'is_calculate_tax',
                'title'         => 'admin::app.admin.system.calculate-tax',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => false,
            ], [
                'name'       => 'cp_mode',
                'title'      => 'canadapost::app.admin.system.mode',
                'type'          => 'select',
                'options'    => [
                    [
                        'title' => 'Development',
                        'value' => 'development',
                    ], [
                        'title' => 'Live',
                        'value' => 'live',
                    ]
                ],
                
            ], [
                'name'          => 'title',
                'title'         => 'canadapost::app.admin.system.title',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'api_userid',
                'title'         => 'canadapost::app.admin.system.api-userid',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
            ], [
                'name'          => 'api_password',
                'title'         => 'canadapost::app.admin.system.api-password',
                'type'          => 'password',
                'info'          => 'Required if status in enabled',
            ], [
                'name'       => 'agreement_type',
                'title'      => 'canadapost::app.admin.system.agreement-type',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'options'    => [
                    [                        
                        'title' => 'Non-Contract',
                        'value' => 'non_contract',
                    ], [
                        'title' => 'Contract',
                        'value' => 'contract',
                    ]
                ],
                
            ], [
                'name'          => 'agreement_number',
                'title'         => 'canadapost::app.admin.system.agreement-number',
                'type'          => 'text',
                'info'          => 'canadapost::app.admin.system.agreement-number-info',
            ], [
                'name'          => 'client_number',
                'title'         => 'canadapost::app.admin.system.client-number',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
            ], [
                'name'       => 'rate_type',
                'title'      => 'canadapost::app.admin.system.rate-type',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'options'    => [
                    [
                        'title' => 'Counter',
                        'value' => 'counter',
                    ], [
                        'title' => 'Commercial',
                        'value' => 'commercial',
                    ]
                ],
                
            ], [
                'name'       => 'weight_unit',
                'title'      => 'canadapost::app.admin.system.weight-unit',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'options'    => [
                    [
                        'title' => 'Pounds',
                        'value' => 'pounds',
                    ], [
                        'title' => 'Kilograms',
                        'value' => 'kilograms',
                    ]
                ],
                
            ], [
                'name'       => 'allowed_methods',
                'title'      => 'canadapost::app.admin.system.allowed-methods',
                'type'       => 'multiselect',
                'options'    => [
                    [
                        'title' => 'Regular Parcel',
                        'value' => 'DOM.RP',
                    ], [
                        'title' => 'Expedited Parcel',
                        'value' => 'DOM.EP',
                    ], [
                        'title' => 'Xpresspost',
                        'value' => 'DOM.XP',
                    ], [
                        'title' => 'Xpresspost Certified',
                        'value' => 'DOM.XP.CERT',
                    ], [
                        'title' => 'Priority',
                        'value' => 'DOM.PC',
                    ], [
                        'title' => 'Library Materials',
                        'value' => 'DOM.LIB',
                    ], [
                        'title' => 'Expedited Parcel USA',
                        'value' => 'USA.EP',
                    ], [
                        'title' => 'Priority Worldwide Envelope USA',
                        'value' => 'USA.PW.ENV',
                    ], [
                        'title' => 'Priority Worldwide pak USA',
                        'value' => 'USA.PW.PAK',
                    ], [
                        'title' => 'Priority Worldwide Parcel USA',
                        'value' => 'USA.PW.PARCEL',
                    ], [
                        'title' => 'Small Packet USA Air',
                        'value' => 'USA.SP.AIR',
                    ], [
                        'title' => 'Tracked Packet – USA',
                        'value' => 'USA.TP',
                    ], [
                        'title' => 'Tracked Packet – USA (LVM)',
                        'value' => 'USA.TP.LVM',
                    ], [
                        'title' => 'Xpresspost USA',
                        'value' => 'USA.XP',
                    ], [
                        'title' => 'Xpresspost International',
                        'value' => 'INT.XP',
                    ], [
                        'title' => 'International Parcel Air',
                        'value' => 'INT.IP.AIR',
                    ], [
                        'title' => 'International Parcel Surface',
                        'value' => 'INT.IP.SURF',
                    ], [
                        'title' => 'Priority Worldwide Envelope Int’l',
                        'value' => 'INT.PW.ENV',
                    ], [
                        'title' => 'Priority Worldwide pak Int’l',
                        'value' => 'INT.PW.PAK',
                    ], [
                        'title' => 'Priority Worldwide parcel Int’l',
                        'value' => 'INT.PW.PARCEL',
                    ], [
                        'title' => 'Small Packet International Air',
                        'value' => 'INT.SP.AIR',
                    ], [
                        'title' => 'Small Packet International Surface',
                        'value' => 'INT.SP.SURF',
                    ], [
                        'title' => 'Tracked Packet – International',
                        'value' => 'INT.TP',
                    ]
                ],
                
            ]
        ]
    ],
];