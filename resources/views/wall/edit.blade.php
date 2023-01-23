@extends('layouts.app')

@section('head')
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
@endsection

@section('content')
    <h1 class="mb-4">{{ __("Edit Wall #$wall->id") }}</h1>
    <form method="POST" action="{{ route('wall.update', $wall->id) }}">
        @csrf
        @method('PUT')
        <label for="title">{{ __('Title') }}</label>
        <input type="text" name="title" class="form-control form-control-lg mb-2 @error('title') is-invalid @enderror"
               placeholder="{{ __('Think of a good title...') }}" value="{{ $wall->title }}">
        @error('title')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <label for="tags">{{ __('Tags') }}</label>
        <input type="text" name="tags"
               class="form-control form-control-sm mt-1 mb-2" data-role="tagsinput" value="{{ $wall->tags }}">

        <label for="body">{{ __('Body') }}</label>
        <textarea id="body" name="body"
                  class="form-control @error('body') is-invalid @enderror">
            {{ bzdecompress($wall->body) }}
        </textarea>
        @error('body')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="mt-3">
            <button type="submit" class="btn btn-success btn-lg" name="publish_status" value="published">
                {{ __('Publish') }}
            </button>
            <button type="submit" class="btn btn-outline-success btn-lg" name="publish_status" value="draft">
                {{ __('Save as Draft') }}
            </button>
        </div>
    </form>
@endsection

@section('dload')
    <script src="https://unpkg.com/@yaireo/tagify@4.16.4/dist/tagify.min.js"></script>
    <script src="https://unpkg.com/@yaireo/tagify@4.16.4/dist/tagify.polyfills.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

    <script type="text/javascript">
        let input = document.querySelector('input[name=tags]');
        // init Tagify script on the above inputs
        let tagify = new Tagify(input, {});
        let easymce = new EasyMDE({
            element: document.getElementById('body'),
            spellChecker: false,
            toolbar: [
                "bold", "italic", "heading", "|",
                "quote", "unordered-list", "ordered-list", "|",
                "link", "image", "table", "|",
                "preview", "side-by-side", "fullscreen", "|",
                "guide"
            ]
        });
    </script>
@endsection
