<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\HeroFaq;
use Illuminate\Http\Request;

class HeroFaqController extends Controller
{

    public function api()
    {
        $heroFaq = HeroFaq::all();
        return response()->json($heroFaq);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroFaq = HeroFaq::all();
        return Inertia::render('Admin/Home/ManageHeroFaq', [
            'dataHeroFaq' => $heroFaq
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Home/CreateHeroFaq');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
        ]);

        $data = $request->only(['question', 'answer']);

        HeroFaq::create($data);

        return redirect()->route('hero-faq.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroFaq $heroFaq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroFaq $heroFaq)
    {
        return Inertia::render('Admin/Home/EditHeroFaq', [
            'dataHeroFaq' => $heroFaq
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroFaq $heroFaq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
        ]);

        $data = $request->only(['question', 'answer']);

        $heroFaq->update($data);

        return redirect()->route('hero-faq.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroFaq $id)
    {
        $id->delete();
        return redirect()->route('hero-faq.index');
    }
}
