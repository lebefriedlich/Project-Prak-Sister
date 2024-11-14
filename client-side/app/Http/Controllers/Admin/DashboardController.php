<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/dashboard';
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return view('Admin.index', [
                    'data' => $body->data
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
        
    }
}
