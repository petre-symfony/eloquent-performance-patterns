<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Post;
use Illuminate\Http\Request;

class FeaturesController extends Controller {
    public function index() {

        $statuses = (object) [];
        $statuses->requested = '-';
        $statuses->planned = '-';
        $statuses->completed = '-';

        $features = Feature::withCount('comments')
            ->paginate();

        return view('features.index', [
            'statuses' => $statuses,
            'features' => $features
        ]);
    }
}
