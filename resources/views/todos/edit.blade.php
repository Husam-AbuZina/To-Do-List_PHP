@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todos App</div>

                    <!-- /resources/views/post/create.blade.php -->

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Create Post Form -->
<br>
                    <h2>Edit Form</h2>
<br>
                    <form method="post" action="{{ route('todos.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                        {{-- this token verify that this info is sent from our app and not any app else --}}
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $todo->title }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" cols="5" rows="5" >{{ $todo->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Status</label>
                            <select name="is_completed" id="" class="form-control">
                                <option disabled selected>Select Option</option>
                                <option value="1">Done</option>
                                <option value="0">To-Do</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
