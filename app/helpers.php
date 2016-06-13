<?php
function generateTestOrderArray(){
    $testRequest = [
        ['ISA' =>
            ['senderId' => 'TRUCKXL', 'receiverId' => 7346778409]
        ],
        ['GS' =>
            ['senderCode' => 'TRUCKXL', 'receiverCode' => 6056649304]
        ],
        ['ST' =>
            ['code' => 850, 'controlNumber' => 1451581466]
        ],
        ['BEG' =>
            ['purposeCode' => '00', 'orderTypeCode' => 'DS', 'purchaseOrderNumber' => '41088269-1']
        ],
        ['CUR' =>
            ['identifierCode' => 'BY', 'currencyCode' => 'USD']
        ],
        ['REF'=>
            [
                ['referenceIdentifier' => 'CO' , 'referenceIdentification' => '00000001'],
                ['referenceIdentifier' => 'GK', 'referenceIdentification' => '41088269-1'],
                ['referenceIdentifier' => 'IA', 'referenceIdentification' => '24']
            ]
        ],
        ['SAC' =>
            [
                ['indicator' => 'N', 'promoCode' => 'C310'],
                ['indicator' => 'N', 'promoCode' => 'H850']
            ]
        ],
        ['ITD' =>
            ['typeCode' => 14, 'dateCode' => 3]
        ],
        ['TDM' =>
            ['dateQualifier' => '038']
        ],
        ['TD5' =>
            ['transportMethod' => 'M', 'routing' => 'Fedex = Home Delivery',
                'serviceCode1' => 'ST', 'serviceCode2' => 'DS']
        ],
        ['identifierLoop' =>
            [
                [
                    'N1' =>
                        ['identifierCode' => 'BT', 'name' => 'Auto Customs Inc.']
                    ,
                    'N3' =>
                        ['addressInfo1' => '2303 SE 17th', 'AddressInfo2' => 'STE 102']
                    ,
                    'N4' =>
                        ['cityName' => 'Ocala', 'state' => 'FL', 'postalCode' => '34471', 'countryCode' => 'US']
                    ,
                    'PER' =>
                        ['functionCode' => 'IC', 'name' =>'Auto Customs, Inc.', 'comQualifier' => 'TE',
                            'comNumber1' => '877-204-7002', 'numberQualifier' => 'EM',
                            'comNumber2' => 'service@autocustoms.com']

                ],
                [
                    'N1' =>
                        ['identifierCode' => 'SO', 'name' => 'TEST ORDER']
                    ,
                    'N3' =>
                        ['addressInfo1' => 'DO NOT SEND', 'AddressInfo2' => '']
                    ,
                    'N4' =>
                        ['cityName' => 'Ocala', 'state' => 'FL', 'postalCode' => '34482', 'countryCode' => 'US']
                    ,
                    'PER' =>
                        ['functionCode' => 'IC', 'name' =>'TEST ORDER', 'comQualifier' => 'TE',
                            'comNumber1' => '352-804-5127', 'numberQualifier' => 'EM',
                            'comNumber2' => '']

                ],
                [
                    'N1' =>
                        ['identifierCode' => 'ST', 'name' => 'TEST ORDER']
                    ,
                    'N3' =>
                        ['addressInfo1' => 'DO NOT SEND', 'AddressInfo2' => '']
                    ,
                    'N4' =>
                        ['cityName' => 'Ocala', 'state' => 'FL', 'postalCode' => '34482', 'countryCode' => 'US']
                    ,
                    'PER' =>
                        ['functionCode' => 'IC', 'name' =>'TEST ORDER', 'comQualifier' => 'TE',
                            'comNumber1' => '352-804-5127', 'numberQualifier' => 'EM',
                            'comNumber2' => '']


                ],
                [
                    'N1' =>
                        ['identifierCode' => 'VN', 'name' => '']
                    ,
                    'N3' =>
                        ['addressInfo1' => '2303 SE 17th St', 'AddressInfo2' => 'STE 102']

                ]
            ]
        ],
        ['productLoop' =>
            [
                [
                    'PO1' => [
                        ['assignedIden' => 0, 'quantity' => 1, 'measurementCode' => 'EA',
                            'unitPrice' => '180.05', 'serviceIdQualifier1' => 'IN',
                            'serviceId1' => '298301', 'serviceIdQualifier2' => 'VN',
                            'serviceId2' => '298301', 'serviceIdQualifier3' => 'UP',
                            'serviceId3' => ''
                        ]
                    ],
                    'PID' => [
                        ['itemDescriptionType' => 'F', 'characteristicCode' => '08', 'description' => 'TEST ITEM']
                    ]
                ]
            ]
        ],
        ['SE' =>
            ['includedSegment' => 31, 'controlNumber' => 1451581466]
        ]
    ];
    return $testRequest;
}