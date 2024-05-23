<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\ShortenUrlRequest;


class UrlShortenerController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function shorten(ShortenUrlRequest $request)
    {
        $originalUrl = $request->input('original_url'); // İstekten gelen 'original_url' verisini al

        // Veritabanında zaten mevcut olan kısa URL'yi kontrol et
        $shortUrl = ShortUrl::where('original_url', $originalUrl)->first();

        if ($shortUrl) {
            // Kısa URL zaten mevcutsa, kullanıcıya mevcut kısa URL'yi göster
            return response()->json(['short_url' => url($shortUrl->short_code)]);
        }

        // Benzersiz kısa kod oluştur
        $shortCode = Str::random(12);
        while (ShortUrl::where('short_code', $shortCode)->exists()) {
            $shortCode = Str::random(12); // Kısa kod zaten varsa, yeni bir tane oluştur
        }

        // Yeni kısa URL kaydı oluştur
        $shortUrl = ShortUrl::create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode
        ]);

        // Kullanıcıya yeni kısa URL'yi göster
        return response()->json(['short_url' => url($shortUrl->short_code)]);
    }


    public function redirect($shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();
        return redirect($shortUrl->original_url);
    }
}
