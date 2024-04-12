<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class RecommendationController extends Controller
{
    public function predict(Request $request)
    {
        $pickleFilePath = Storage::path('storage/app/trek_recommendation.pkl');
        echo "Path to the pickled file: " . $pickleFilePath;
        $model = joblib::load($pickleFilePath);

        $inputData = $request->input('budget');
        $prediction = $model->predict($inputData);

        return response()->json(['prediction' => $prediction]);
    }
}
