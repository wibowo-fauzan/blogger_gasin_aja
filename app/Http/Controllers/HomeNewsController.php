<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeNewsController extends Controller
{
    public function index()
    {
        $apiUrl = 'https://newsapi.org/v2/top-headlines?country=id&apiKey=771455cfa6c4435e8bc9c3ae31bf8cb0';
        $response = Http::get($apiUrl);

        // Pastikan respons sukses
        if ($response->successful()) {
            $articles = $response->json()['articles']; // Ambil data artikel dari JSON
            return view('welcome', compact('articles'));
        } else {
            return response('Error fetching data from API', 500);
        }
    }
}
