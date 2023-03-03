<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Post;
use Illuminate\Http\Request;

class FeaturesController extends Controller {
    /**
     * public index for chapter 5

    public function index() {

        $statuses = Feature::toBase()
            ->selectRaw("count(case when status = 'Requested' then 1 end) as requested")
            ->selectRaw("count(case when status = 'Planned' then 1 end) as planned")
            ->selectRaw("count(case when status = 'Completed' then 1 end) as completed")
            ->first();
        * /
        /**
         * You can use filter when postgress database are used
         *
        $statuses = Feature::toBase()
            ->selectRaw("count(*) filter (where status = 'Requested') as requested")
            ->selectRaw("count(*) filter (where status = 'Planned') as planned")
            ->selectRaw("count(*) filter (where status = 'Completed') as completed")
            ->first();
         */
        /**
        $features = Feature::withCount('comments')
            ->paginate();

        return view('features.index', [
            'statuses' => $statuses,
            'features' => $features
        ]);
    }
    */

    public function index() {
        $features = Feature::withCount('comments')
            ->paginate();

        return view('features.index', ['features' => $features]);
    }

    public function show(Feature $feature){
        $feature->load('comments.user');
        $feature->comments->each->setRelation('feature', $feature);

        return view('features.show', ['feature' => $feature]);
    }
}
