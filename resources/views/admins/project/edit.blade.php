@extends('layouts.app')

@section('content')
<div class="container" id="projects-conteiner">
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="{{ route('admin.projects.update', $project->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleFormControlInput" class="form-label">
                    Title
                </label>
                <input type="text" class="form-control" id="title" placeholder="Insert your project title" name="title" value="{{ $project->title}}">
            </div>
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleFormControlInput" class="form-label">
                    Image
                </label>
                <input type="file" name="image" id="image" class="form-control" value="{{ old('image', '')}}">
            </div>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="content" class="form-label">
                    Content
                </label>
                <textarea class="form-control" id="content" rows="7" name="content">
                    {{ $project->content}}"
                </textarea>
            </div>

            <div class="mb-3">
                <button type="submit">
                    Update project
                </button>
                <button type="reset">
                    Reset
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
