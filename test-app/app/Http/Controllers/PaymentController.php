<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $client;
    private $baseUrl = 'http://204.8.207.124:8080/coralpay-vas/api/';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function customerLookup(Request $request)
    {
        try {
            $validated = $request->validate([
                'customerId' => 'required|string',
                'billerSlug' => 'required|string',
                'productName' => 'required|string',
            ]);

            // Creating the body for the request
            $body = json_encode($validated);

            // Sending the request to the external API
            $response = $this->client->post($this->baseUrl . 'transactions/customer-lookup', [
                'auth' => [env('CORALPAY_USERNAME'), env('CORALPAY_PASSWORD')],
                'body' => $body,
                'headers' => ['Content-Type' => 'application/json'],
            ]);

            // Return the response as JSON
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Handle the exception and return an appropriate response
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'paymentReference' => 'required|string',
                'customerId' => 'required|string',
                'packageSlug' => 'required|string',
                'channel' => 'required|string',
                'amount' => 'required|numeric',
                'customerName' => 'required|string',
                'phoneNumber' => 'required|string',
                'email' => 'required|email',
                'accountNumber' => 'required|string',
            ]);

            // Creating the body for the request
            $body = json_encode($validated);

            // Sending the request to the external API
            $response = $this->client->post($this->baseUrl . 'transactions/process-payment', [
                'auth' => [env('CORALPAY_USERNAME'), env('CORALPAY_PASSWORD')],
                'body' => $body,
                'headers' => ['Content-Type' => 'application/json'],
            ]);

            // Return the response as JSON
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Handle the exception and return an appropriate response
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 50);
        }
    }
}