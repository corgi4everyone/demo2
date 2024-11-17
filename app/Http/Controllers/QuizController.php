<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Quiz;

class QuizController extends Controller
{
    //
    public function index($tab = 'remaining'){

        if(!in_array($tab,['remaining','results'])){
            abort(404);
        }

        $quizzes = Quiz::query()
        ->with(['course' => function ($query) {
            $query-> select('id', 'course_code', 'title');
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
        ->map(function ($quiz) use ($tab) {
            $data = [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'due_date' => $quiz->due_date,
                'course_code' => $quiz->course->course_code,
                'course_title' => $quiz->course->title,
                'is_submitted' => $quiz->submissions->isNotEmpty(),
            ];
            if($tab === 'results'){
                $grade = $quiz->submissions->first()->grade;
                $data['grade'] = $grade ? $grade->grade : '';
            }

            return $data;
        });

        

        return Inertia::render('Quiz/Index',[
            'quizzes' => $quizzes,
            'currentTab' => $tab,
        ]);
    }
}
