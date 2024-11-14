<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi',
            'email' => 'Kolom :attribute harus berupa email',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        $client = new Client();

        $apiUrl = config('app.api_url') . '/api/login';
        $response = $client->request('POST', $apiUrl, [
            'form_params' => [
                'email' => $request->email,
                'password' => $request->password,
            ]
        ]);

        $body = json_decode($response->getBody());

        if ($response->getStatusCode() == 200) {
            Cookie::queue('api_token', $body->token, 60);
            if ($body->user->role == 'Admin') {
                Cookie::queue('user_role', $body->user->role, 60);
                Cookie::queue('user_id', $body->user->id_user, 60);
                return redirect()->route('dashboard');
            } else if ($body->user->role == 'User') {
                Cookie::queue('user_role', $body->user->role, 60);
                Cookie::queue('user_id', $body->user->id_user, 60);
                return redirect()->route('landing-page');
            }
        } else {
            return redirect()->route('login')->with('error', $body->message);
        }
    }

    public function register()
    {
        return view('register');
    }

    public function postRegister(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'max_digits' => 'Kolom :attribute maksimal 13 digit.'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'no_hp' => 'required|numeric|max_digits:13',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('register')->withErrors($validator)->withInput();
        }

        $client = new Client();

        $apiUrl = config('app.api_url') . '/api/register';
        $response = $client->request('POST', $apiUrl, [
            'form_params' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'no_hp' => $request->no_hp,
            ]
        ]);

        $body = json_decode($response->getBody());

        if ($response->getStatusCode() == 201) {
            return redirect()->route('login')->with('success', $body->message);
        } else {
            return redirect()->route('register')->with('error', $body->message);
        }
    }

    public function logout()
    {
        $client = new Client();

        $apiUrl = config('app.api_url') . '/api/logout';
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cookie::get('api_token'),
            ]
        ]);

        $body = json_decode($response->getBody());

        if ($response->getStatusCode() == 200) {
            Cookie::queue(Cookie::forget('api_token'));
            Cookie::queue(Cookie::forget('user_role'));
            Cookie::queue(Cookie::forget('user_id'));
            return redirect()->route('login')->with('success', $body->message);
        } else {
            return redirect()->route('login')->with('error', $body->message);
        }
    }
}
