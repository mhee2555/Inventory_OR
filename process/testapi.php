<?php


for ($i = 0; $i < 1; $i++) {
    $detial_item[] = array(
        'item_code' => 'BMCDSSW2L200226',
        'item_name' => 'Cerclage tunneling set',
        'sterile_reason' => 'Sterile',
        'qty' => 2,
        'remark' => '1'
    );
}

// {
//     "order_no":"T000002",
//     "employee_code":"EM00002",
//     "employee_name":"\u0e04\u0e38\u0e13 \u0e2a\u0e31\u0e15\u0e22\u0e32 \u0e28\u0e23\u0e35\u0e22\u0e32\u0e1a",
//     "contact_type":"Network",
//     "contact_name":"01DEN - Dental Center (BMC) xx",
//     "hospital":"Bangkok Hospital",
//     "sale":"none",
//     "hospital_transfer":"none",
//     "site":"BMC","customer_code":"01DEN",
//     "system_name":"DentalSterileAPI",
//     "detial_item":[
//         {"item_code":"BMCDPRP1M100001",
//             "item_name":"BURR (DENTAL)",
//             "sterile_reason":"1",
//             "qty":3,"remark":"0"
//         },
//         {"item_code":"BMCDPRP1M100002",
//             "item_name":"MOUTH RETACTER (DENTAL)",
//             "sterile_reason":"1",
//             "qty":5,
//             "remark":"0"
//         }
//         ]
//     }
$data_array = array(
    'order_no' => 'T000002',
    'employee_code' => '909999',
    'employee_name' => 'name',
    'contact_type' => 'Network',
    'contact_name' => '01DEN - Dental Center (BMC) xx',
    'hospital' => 'Bangkok Hospital',
    'sale' => 'none',
    'hospital_transfer' => 'none',
    'site' => 'BMC',
    'customer_code' => '01DEN',
    'system_name' => 'DentalSterileAPI',
    'detial_item' => $detial_item
);

$data_array = json_encode($data_array);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api-dev.nhealth-asia.com/nh-nsterile-open/api/v1/create_order_request_nsterile',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $data_array,
    CURLOPT_HTTPHEADER => array(
        'client_id: e37e81050cff41a3bc560e183961484e',
        'client_secret: 123D933F47Fc466FA6d711098b95CbD5',
        'Content-Type: application/json',
        'Cookie: __cfruid=066a06c72bb0bca49c27c8fdd941973c0c5cf181-1708480984'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
