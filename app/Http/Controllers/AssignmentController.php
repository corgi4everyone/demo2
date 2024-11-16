<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($tab = 'remaining')
    {
        // Ensure the selected tab is valid, otherwise throw 404
        if (!in_array($tab, ['remaining', 'results'])) {
            abort(404);
        }

        // Query assignments with course details and filter based on submission status
        $assignments = Assignment::query()
            ->with(['course' => function ($query) {
                $query->select('id', 'course_code', 'title');
            }])
            ->with('submissions')
            ->when($tab === 'remaining', function ($query) {
                return $query->doesntHave('submissions');
            })
            ->when($tab === 'results', function ($query) {
                return $query->has('submissions')
                ->with('submissions.grade');
            })
            ->get()
            ->map(function ($assignment) use ($tab) {
                // Add course_code and name to each assignment's response
                $data = [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'due_date' => $assignment->due_date,
                    'course_code' => $assignment->course->course_code,
                    'course_title' => $assignment->course->title,
                    'is_submitted' => $assignment->submissions->isNotEmpty(),
                ];
                if($tab === 'results'){
                    $grade = $assignment->submissions->first()->grade;
                  
                    $data['grade'] = $grade? $grade->grade : '';
                }
                return $data;
            });

        // Return the response with assignments and current tab
        return Inertia::render('Assignment/Index', [
            'assignments' => $assignments,
            'currentTab' => $tab,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
