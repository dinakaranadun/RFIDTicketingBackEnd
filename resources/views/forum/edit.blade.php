@extends('layouts.app')
@section('title', 'Edit Forum Question')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('forum.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <!-- Existing question details -->
                                <div class="col-md-12">
                                    <label class="form-label">Question</label>
                                    <div class="form-group">
                                        <input id="contentTextarea" type="text" name="title" class="form-control" value="{{ $question->title }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Content</label>
                                    <div class="form-group">
                                        <textarea name="content" class="form-control" rows="4" disabled>{{ $question->content }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Display existing answers -->
                            <div class="mt-4">
                                <h5>Answers</h5>
                                @forelse ($question->answers as $answer)
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <p>{{ $answer->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>No answers yet.</p>
                                @endforelse
                            </div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-primary btn-round" id="reply-btn">Add Reply</button>
                                <div id="reply-area" class="mt-3" style="display:none;">
                                    <textarea name="reply_content" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-round">Submit Reply</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#reply-btn').on('click', function() {
            $('#reply-area').toggle(); 
        });
    });
    
</script>
@endpush
