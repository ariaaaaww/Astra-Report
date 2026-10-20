<?php

namespace App\Http\Controllers;

class SupervisorReviewController
{
    public function index()
    {
        return view('supervisor_review.index');
    }

    public function show($submission_id)
    {
        return view('supervisor_review.show', compact('submission_id'));
    }

    public function review($submission_id)
    {
        // Validate and store or update the supervisor review data
        // ...
        return redirect()->route('supervisor_review.index');
    }
}
