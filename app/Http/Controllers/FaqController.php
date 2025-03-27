<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();

        // Jika ingin mengirimkan data ke Blade
        return view('Chatify::pages.app', compact('faqs'));

        // Jika ingin mengirimkan data sebagai JSON
        return response()->json($faqs);
    }
}
