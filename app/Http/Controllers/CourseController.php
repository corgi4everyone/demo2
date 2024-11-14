<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Carbon\Carbon;
use Inertia\Inertia;

class CourseController extends Controller
{
    //index
    public function index($tab = 'ongoing')
    {
        $now = Carbon::now();

        $courses = Course::query()
            ->when($tab === 'ongoing', function ($query) use ($now) {
                return $query->where('end_date', '>', $now);
            })
            ->when($tab === 'completed', function ($query) use ($now) {
                return $query->where('end_date', '<=', $now);
            })
            ->get()
            ->map(function ($course) use ($now) {
                $startDate = Carbon::parse($course->start_date);
                $endDate = Carbon::parse($course->end_date);
                $totalDuration = $startDate->diffInDays($endDate);
                $daysElapsed = $startDate->diffInDays($now);

                $progress = $totalDuration > 0
                    ? min(100, max(0, ($daysElapsed / $totalDuration) * 100))
                    : 0;

                $course->progress = round($progress);
                return $course;
            });

        if (!in_array($tab, ['ongoing', 'completed'])) {
            abort(404);
        }

        return Inertia::render('Course/Index', [
            'courses' => $courses,
            'currentTab' => $tab,
        ]);
    }

    //create
    public function create()
    {
        return inertia('Course/Create',[
            //
        ]);
    }
    //store

    //show
//    public function show(Course $course)
//    {
//
//        $course = Course::with('slides', 'assignments', 'forumPosts', 'quizzes')->get();
//        return inertia('Course/Show', [
//            'course' => $course,
//        ]);
//    }

    public function show(Course $course, $tab = 'slides')
    {
        // Load relationships based on current tab
        $course->load(match($tab) {
            'slides' => ['slides', 'quickLinks'],
            'assignments' => ['assignments'],
            'quizzes' => ['quizzes'],
            'forum_posts' => ['forumPosts'],
            default => []
        });

        return Inertia::render('Course/Show', [
            'course' => $course,
            'currentTab' => $tab,
            'tab' => $tab, // Add this line
        ]);
    }

    //edit

    //update

    //delete
}
