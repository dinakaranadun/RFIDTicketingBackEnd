<?php

namespace App\Http\Controllers\Admin;

use App\Models\Forum;
use App\Models\ForumAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    
        public function index(Request $request)
    {
        $categories = Forum::select('category')->distinct()->pluck('category');




        $unansweredQuestions = Forum::doesntHave('answers')
        ->when($request->name, function ($query, $name) {
            return $query->where('title', 'LIKE', '%' . $name . '%');
        })
        ->when($request->category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->paginate(10);

    $answeredQuestions = Forum::has('answers')
        ->when($request->name, function ($query, $name) {
            return $query->where('title', 'LIKE', '%' . $name . '%');
        })
        ->when($request->category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->paginate(10);

        return view('forum.index', compact('unansweredQuestions', 'answeredQuestions','categories'));
        
    }


    public function edit(Forum $forum){

        $question = Forum::with('answers')->findOrFail($forum->id);

        return view('forum.edit', compact('question'));


    }

    public function update(Request $request, Forum $forum)
    {
        

        $request->validate(
            [
                'reply_content' => 'string|nullable',
            ],
            [],
            [
                'reply_content' => 'Reply',
            ]
        );

        $forumAnswer = new ForumAnswer();
        $forumAnswer->content = $request->reply_content;
        $forumAnswer->question_id = $forum->id;
        // $forumAnswer->user_id = Auth::id(); 
        $forumAnswer->save();

        return redirect()->route('forum.index')->with('success', 'Reply added successfully');


    }

    public function destroy(Forum $forum)
    {
        $forum->delete();
        return redirect()->route('forum.index')->with('success', 'Question deleted successfully');
    }
    
}
