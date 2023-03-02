<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Post;
use Illuminate\Http\Request;

class FeaturesController extends Controller {
    public function index() {

        $statuses = (object) [];
        $statuses->requested = Feature::where('status', 'Requested')->count();
        $statuses->planned = Feature::where('status', 'Planned')->count();
        $statuses->completed = Feature::where('status', 'Completed')->count();

        $features = Feature::withCount('comments')
            ->paginate();

        return view('features.index', [
            'statuses' => $statuses,
            'features' => $features
        ]);
    }
}
