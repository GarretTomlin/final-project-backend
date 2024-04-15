<?php

namespace App\Http\Controllers\StoreController;

class StoreController
{

    public function edit($id){
        $store = Store:: find($id);
        return view('edit', compact('store'));
    }

    public function update(Request $request, Store $store)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Update the store
    $store->name = $request-> input ('name');
    $request->description = $request-> input ('description');
    $store->update();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Store updated successfully!');
}

}
