<?php

namespace App\Http\Controllers;

use App\Enums\TypeCategory;
use App\Models\Category as ModelsCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Category extends Controller
{
    /**
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = ModelsCategory::get();
        $types = TypeCategory::getCollection();
        return response()->json(compact('categories', 'types'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('!!!!!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
