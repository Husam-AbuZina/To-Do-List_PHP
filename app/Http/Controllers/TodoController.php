<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index() {
        $todos = Todo::get();
        foreach($todos as $key){
            $key['user'] = User::where('id',$key->user_id)->first(); // we can get colums one by one, but used "all()" instead
        }
        $userId = Auth::id();
        return view('todos.index', [
            'todos' => $todos
        ]);
    }

    public function create() {
        return view('todos.create'); // call it by the name we gave it at the route file "web.php"
    }

    public function store(TodoRequest $request) { //first validate the user.

        $request->validated(); //safe way to take input from users

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->is_active = 0;
        $todo->user_id = auth()->user()->id;
        $todo->save();

        return redirect()->route('todos.index')->with('success','تم اضافة المهمة بنجاح');

        //will accept all data coming form the form inside the "create.blade.php" file
        //model::create($request->all());
        //create() // is a helper function that shorcuts the function of (INSERT VALUES INTO DATABASE ...)
         }

         public function show($id){
            $todo = Todo::find($id); //find is a key word, get if from the model, the database
            if(! $todo){
                request()->session()->flash('error', 'Unable to locate the  Todo');
                return to_route('todos.index')->withErrors([
                    'error' => 'Unable to locate the Todo'
                ]);
            }
            return view('todos.show', ['todo' => $todo]); //return $id; // show id, just to ensure the code is working
         }

         public function edit($id){
            $todo = Todo::find($id); //find is a key word, get if from the model, the database
            if(! $todo){
                request()->session()->flash('error', 'Unable to locate the  Todo');
                return to_route('todos.index')->withErrors([
                    'error' => 'Unable to locate the Todo'
                ]);
            }
            return view('todos.edit', ['todo' => $todo]);
         }

         public function update(TodoRequest $request){
            $todo = Todo::find($request->todo_id); //.todo_id is the name of the input inside the "edit.bladew.php" file.
            if(! $todo){
                request()->session()->flash('error', 'Unable to locate the  Todo');
                return to_route('todos.index')->withErrors([
                    'error' => 'Unable to locate the Todo'
                ]);
            }

            //dd($request->is_completed); // just to check is_completed's value
            $todo->update([
                'title' => $request->title,
                'description' => $request->description,
                'is_completed' => $request->is_completed
            ]);
            $request->session()->flash('alert-info', 'Todo Updated Successfully');
            return to_route('todos.index');
         }

         public function destroy(Request $request){
            $todo = Todo::find($request->todo_id); //.todo_id is the name of the input inside the "edit.bladew.php" file.
            if(! $todo){
                request()->session()->flash('error', 'Unable to locate the  Todo');
                return to_route('todos.index')->withErrors([
                    'error' => 'Unable to locate the Todo'
                ]);
            }

            $todo->delete();
                  $request->session()->flash('alert-info', 'Todo Updated Successfully');
            return to_route('todos.index');
            //dd($todo); // our to do that we want to delete.
         }
}

