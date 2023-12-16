<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
   use App\Models\Question;

class AnswerController extends Controller
{
    public function update (Request $request, Answer $answer){
        $answers = $request->all();

        foreach ($answers as $a){
             $id = $a['id'];
             $updateAnswer=Answer::findOrFail($id);
             $updateAnswer->answer=$a['answer'];
             $updateAnswer->correct_answer=$a['correct_answer'];
             $updateAnswer->save();
             
        }
        return redirect('/question')->with('success','Answer has been updated');
    }

    public function destroy ( Answer $answer){
      //
    }
}
