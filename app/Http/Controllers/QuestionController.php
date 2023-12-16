<?php
   
   namespace App\Http\Controllers;

   use Inertia\Inertia;
   use App\Models\Answer;
   use App\Models\Question;
   use Illuminate\Http\Request;

   class QuestionController extends Controller
   {
      

      public function store(Request $request){
         $requestdata=$request->all();
         $question=$requestdata['question'];

         //   save question
         $newQuestion=new Question;
         $newQuestion->question=$question;
         $newQuestion->save();

         $answers=$requestdata['answers'];

         foreach($answers as $answer){
            $newAnswer = new Answer;
            $newAnswer -> answer=$answer['answer'];
            $newAnswer -> question_id = $newQuestion->id;
            $newAnswer -> correct_answer = $answer['correct_answer'];
            $newAnswer -> save();
         }

         return redirect ('/question') ->with('success', 'Question and Answers created successfully.');

      }

      
      public function index(){
         $questions=Question::with('answers')->get();
           return Inertia::render('Question',[
           'questions'=>$questions
        ]);
     }

      public function show (Question $question){

      }
   }
