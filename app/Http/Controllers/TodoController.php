<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index() {
        $todos = Todo::all(); // we can get colums one by one, but used "all()" instead
        return view('todos.index', [
            'todos' => $todos
        ]);
    }

    public function create() {
        return view('todos.create'); // call it by the name we gave it at the route file "web.php"
    }

    public function store(TodoRequest $request) { //first validate the user.
        //use request vlass so you can get all of the fields of the form using thsi request
        //return $request->description;


        //.Todo:create($request->all()); //this line of code will threat your security //solution: using custom array

        $request->validated(); //safe way to take input from users

        //.Todo::created($request->all()) //this isDangerious, users can append any text field (like SQL commands "SQL injection")

        //$request->validated(); // Undisable me in real life, i am security code.
         // will take 2 inputs as condition to accept input from user.



        Todo::create([
            'title' => $request->title,   //name="title" in the form => it is a database column
            'description' => $request->description,
            'is_active' => 0
        ]);

        $request->session()->flash('alert-success', 'Todo Created Successfully'); //session name and session Value.
// flash Helper
        //return redirect()->route();  this code is before laravel 9
        return to_route('todos.index');

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

