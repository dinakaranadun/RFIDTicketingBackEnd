@extends('layouts.app')
@section('title', 'Forum')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="GET">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control"
                                            value="{{ request()->get('name', '') }}">
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $error }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-control">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ request()->category == $category ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                    </select>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $error }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-info btn-round">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Unanswered Questions Section -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Unanswered Questions
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <th>Question</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($unansweredQuestions as $question)
                                        <tr>
                                            <td>
                                                {{ $question->title }}
                                            </td>
                                            <td>
                                                {{ $question->category}}  
                                            </td>
                                            <td>
                                                <a href="{{ route('forum.edit', $question->id) }}" class="btn btn-warning btn-round">Reply</a>
                                                <form action="{{ route('forum.destroy', $question->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-round"
                                                        onclick="return confirm('Are you sure you want to delete this route?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $unansweredQuestions->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answered Questions Section -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        Answered Questions
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <th>Question</th>
                                    <th>Content Preview</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($answeredQuestions as $question)
                                        <tr>
                                            <td>
                                                {{ $question->title }}
                                            </td>
                                            <td>
                                                {{ $question->category}} 
                                            </td>
                                            <td>
                                                <a href="{{ route('forum.edit', $question->id) }}" class="btn btn-warning btn-round">View Replies / Reply</a>
                                                <form action="{{ route('forum.destroy', $question->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-round">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $answeredQuestions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
