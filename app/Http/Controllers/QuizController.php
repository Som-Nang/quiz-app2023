<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use Inertia\Inertia;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with(['answers'=> function($query){
            $query->inRandomOrder();
        }])->inRandomOrder()->get();

        return Inertia::render('Quiz',[
            'questions'=>$questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function results(Request $request)
    {
        $score = $request[0]['results']['score'];
        $totalQuestion = $request[0]['results']['totalQuestion'];

        $percentage=ceil(($score/$totalQuestion)*100);
        $comment=match(true){
            $percentage >= 80 && $percentage <= 100 => 'Congratulation',
            $percentage >= 60 && $percentage <= 79 => 'IMpressive',
            $percentage >= 40 && $percentage <= 59 => 'Almost there!',
            $percentage >= 39 => 'Uh-No',

            default=> 'Well how did you reach herr?'
        };

        return Inertia::render('Result',[
            'percentage'=>$percentage,
            'comment'=>$comment,
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}