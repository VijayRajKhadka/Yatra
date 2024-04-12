<?php

namespace App\Http\Controllers;
use App\Models\Trek;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function treks()
    {
        $treks = Trek::paginate(2); 
        return view('admin.trek', compact('treks'));
    }

    public function getTrekDetails($trek_id)
    {  
        $treks = Trek::findOrFail($trek_id);

        $trekImage = Trek::with('trek_image')->find($trek_id);

        return view('admin.trek_details', compact('treks', 'trekImage'));
    }

    public function updateTrekDetails(Request $request, $trek_id)
{
    $trek = Trek::find($trek_id);
    $trek->name = $request->input('name');
    $trek->description = $request->input('description');
    $trek->location = $request->input('location');
    $trek->category = $request->input('category');
    $trek->altitude = $request->input('altitude');
    $trek->difficulty = $request->input('difficulty');
    $trek->no_of_days = $request->input('no_of_days');
    $trek->emergency_no = $request->input('emergency_no');
    $trek->budgetRange = $request->input('budgetRange');
    $trek->approve = $request->input('approve');
    $trek->update();

    return redirect()->route('adminTrek', $trek_id)->with('success', 'Trek details updated successfully.');
}


}
