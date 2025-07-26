<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function feedback()
    {   
        // Get paginated feedback
        $feedbacks = Feedback::orderBy('created_at', 'desc')->paginate(10);
        
        // Calculate statistics
        $totalFeedback = Feedback::count();
        $averageRating = Feedback::avg('rating');
        $bugReportsCount = Feedback::where('type', 'Bug report')->count();
        $featureRequestsCount = Feedback::where('type', 'Feature request')->count();
        
        return view('admin.feedback', compact(
            'feedbacks',
            'totalFeedback',
            'averageRating',
            'bugReportsCount',
            'featureRequestsCount'
        ));
    }
}
