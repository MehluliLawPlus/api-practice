<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/aml-authenticate', function () {

    $data = array(
        "ApiKey" => "lwmsrzlst+02S0N2X19LFa9H5Npfcu5F3+A4SDC8Y7dHE1rWOHwzIwDJxNXAFS9vMOviSbPilp0rDDe5rnAnHw=="
    );

    $data = json_encode($data);
    // dd($data);
    // Make a curl request to update a token
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://staging-api.valid8.cloud/v1/authentication/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $result = json_decode($result);
    log::info($result->result->token);
    dd($result->result->token);


    // return view('auth');
});

Route::get('/aml-post-data', function () {

    $authToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiIyZGY5MDM2MmJlZGU0YzA1OGFiYWJlZTQ5YTY4NzNiYyIsImlhdCI6MTcwNzMyNTk0NiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwNS8wNS9pZGVudGl0eS9jbGFpbXMvbmFtZWlkZW50aWZpZXIiOiIxMTUiLCJHbG9iYWxJZCI6ImVjZTQxZDA1ZjY2MzQ2MmFiMGYxMmY3YmYyYTdkMGUyIiwiQWxsb3dFeHBlcmlhblNpbXBsZSI6InRydWUiLCJBbGxvd0V4cGVyaWFuRnVsbCI6InRydWUiLCJBbGxvd09wZW5CYW5raW5nIjoidHJ1ZSIsIkFsbG93UG9zdGNvZGVMb29rdXAiOiJ0cnVlIiwiQWxsb3dBbWwiOiJ0cnVlIiwiQWxsb3dWZWhpY2xlTG9va3VwIjoidHJ1ZSIsIm5iZiI6MTcwNzMyNTk0NiwiZXhwIjoxNzA3MzI3NzQ2LCJpc3MiOiJodHRwczovL3N0YWdpbmctYXBpLnZhbGlkOC5jbG91ZCIsImF1ZCI6Imh0dHBzOi8vc3RhZ2luZy1hcGkudmFsaWQ4LmNsb3VkIn0.7xcsxKSID_qylnWiujOEHK19c20Qo906lPmQSJ52pFY";
    //data sent to the API for AML checks.
    $title = "Mr";
    $firstName = "Shenol";
    $lastName = "Hoines";
    $dateOfBirth = "1946-09-01";
    $email = "...@gmail.com";
    $phone = "0783";
    $addressSearch = "addresss";
    $addressFlat = "";
    $addressNumber = "";
    $addressLine1 = "";
    $addressLine2 = "";
    $addressTown = "Westbury";
    $addressCountry = "";
    $addressPostcode = "BA133BN";

    $personalDetails = array(
        "title" => $title,
        "forename" => $firstName,
        "surname" => $lastName,
        "dateOfBirth" => $dateOfBirth
    );

    $address = array(
        "country" => "United Kingdom",
        "street"  => "High Street",
        "city" => $addressTown,
        "zipPostCode" => $addressPostcode,
        "building" => "109"
    );

    $data = array(
        "reference" => $firstName." ".$lastName,
        "includeJsonReport" => true,
        "includePdfReport" => false,
        "personalDetails" => (object) $personalDetails,
        "contactDetails" => null,
        "currentAddress" => (object) $address,
        "previousAddress1" => null,
        "previousAddress2" => null,
        "previousAddress3" => null
    );

    $data = json_encode($data);
    // dd($data);
    // Make a curl request to update a token
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://staging-api.valid8.cloud/v1/identity/aml/verify');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer'." ".$authToken;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        dd( curl_error($ch));
    }
    curl_close($ch);

    $result = json_decode($result);
    dd($result);

    return view('auth');
});

Route::get('/virtual-signal-auth', function () {
    $data = "";
    // Make a curl request to update a token
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://portal.virtualsignature.com/api/requestauth');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'api_key: DHGO73C8312TSLN5F5V7';
    $headers[] = 'application_key: 3TJOAN1N0VV9SREYGDST';
    $headers[] = 'user_email: simon@lawplus.co.uk';

    // $headers[] = 'Authorization: Bearer'." ".$authToken;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        dd( curl_error($ch));
    }
    curl_close($ch);

    $result = json_decode($result);
    dd($result);

});

Route::get('/virtual-check-session', function () {
    $data = "";
    // Make a curl request to update a token
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://portal.virtualsignature.com/api/requestauth');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'api_key: DHGO73C8312TSLN5F5V7';
    $headers[] = 'application_key: 3TJOAN1N0VV9SREYGDST';
    $headers[] = 'user_email: simon@lawplus.co.uk';

    // $headers[] = 'Authorization: Bearer'." ".$authToken;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        dd( curl_error($ch));
    }
    curl_close($ch);

    $result = json_decode($result);
    dd($result);
});

Route::get('/virtual-sessionligin', function () {
    $data = "";
    // Make a curl request to update a token
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://portal.virtualsignature.com/api/sessionlogin');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'api_key: DHGO73C8312TSLN5F5V7';
    $headers[] = 'application_key: 3TJOAN1N0VV9SREYGDST';
    $headers[] = 'user_email: simon@lawplus.co.uk';

    // $headers[] = 'Authorization: Bearer'." ".$authToken;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        dd( curl_error($ch));
    }
    curl_close($ch);

    $result = json_decode($result);
    dd($result);
});