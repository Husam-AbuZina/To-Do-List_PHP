@extends('layouts.app')

@section('styles')
<style>
    #outer
{
    width:auto;
    text-align: center;
}
.inner
{
    display: inline-block;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>


                @if (Session::has('alert-success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('alert-success') }}
                  </div>
                @endif

                @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                  </div>
                @endif

                @if (Session::has('alert-info'))
                <div class="alert alert-info" role="alert">
                    {{ Session::get('alert-info') }}
                  </div>
                @endif

                <a class="btn btn-sm btn-info"  href="{{ route('todos.create')}}">Add To-Do</a>

                @if(count($todos) > 0)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Completed</th>
                <th scope="col">Actions</th>
                <th scope="col">AddedBy</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todos as $todo)
                <tr>
                    <td>{{ $todo->title }}</td>
                    <td>{{ $todo->description }}</td>
                    <td>
                        @if ($todo->is_active == 1)
                            <a href="" class="btn btn-sm btn-success">Done</a>
                        @else
                            <a href="" class="btn btn-sm btn-success">To-Do</a>
                        @endif
                    </td>
                    <td id="outer">
                        <a href="{{ route('todos.show', $todo->id)}}" class="inner btn btn-sm btn-success">View</a>
                        <a href="{{route('todos.edit', $todo->id)}}" class="inner btn btn-sm btn-info">Edit</a>
                        <form action=" {{route('todos.destroy')}} " method="POST" class="inner">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="todo_id" value="{{$todo->id}}">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                    <td>
                        {{ $todo['user']->name}}
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@else

    <h4>There are no To-Dos!</h4>
@endif




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
