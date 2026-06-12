@extends('layouts.app', [
    'title' => 'Edit Job | Akhani Connect',
    'heading' => 'Edit Job Post',
    'subheading' => 'Update vacancy details before candidates apply.',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('recruitment.jobs.update', $job) }}">
                @csrf
                @method('PUT')

                @include('recruitment.jobs._form', ['submitLabel' => 'Update job post'])
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#job_description_editor'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'link',
                    'blockQuote',
                    'insertTable',
                    '|',
                    'undo',
                    'redo',
                ],
            })
            .catch(function (error) {
                console.error(error);
            });
    </script>
@endpush
