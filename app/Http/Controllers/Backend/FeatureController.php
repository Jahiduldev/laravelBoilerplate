<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Repositories\Feature\IFeatureRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    public function __construct(private IFeatureRepository $featureRepository) {
    }

    public function allFeature()
    {
        $features = $this->featureRepository->getAllFeatures();
        return view('backend.feature.feature_all', compact('features'));
    }

    public function addFeature()
    {
        return view('backend.feature.feature_add');
    }

    public function storeFeature(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name' => $request->input('feature_name'),
                'user_id' => Auth::id(),
            ];
            $this->featureRepository->create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Feature added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add feature. Please try again.');
        }
    }
}
