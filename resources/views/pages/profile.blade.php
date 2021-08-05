@extends('layouts.layout')

@push('css')
    <link href="{{ asset('assets/plugins/filepond/filepond.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js.header')
    <script src="{{ asset('assets/plugins/jQuery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond.min.js') }}"></script>
@endpush


@section('title')
    Profil {{ $user->name }}
@endsection


@section('content')

    <div class="col-12
                mx-auto
                mx-5 mt-2 mb-3 fs-3 pt-2 pb-3 ps-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">


                <div class="row">

                    <div class='col-4
                                p-4
                                text-center'>

                                    <img class="my-0
                                                mx-0 mx-lg-3 mx-xl-5
                                                img-thumbnail"
                                                src="{{ asset($user->avatar) }}">

                                <span class="ms-2 fs-4">
                                    <strong>{{ $user->name }}</strong>
                                </span>

                    </div>

                    <div class="col-8
                                pt-4 pb-4 pe-4">

                                Zmień awatar <input type="file" labelIdle="siema" class="filepond">
                                <input type="file" name='file' class='filepond' multiple id='file_upload' />
                    </div>

                </div>

    </div>

    <script>

FilePond.parse(document.body);
const inputElement = document.querySelector('#file_upload');

FilePond.registerPlugin(FilePondPluginImagePreview);

const pond = FilePond.create(inputElement, {
  allowMultiple: true,
  imagePreviewHeight: 135,
  labelIdle: `
    <div style="width:100%;height:100%;">
    	<p>
        Drag &amp; Drop ydsadsadsales or <span class="filepond--label-action" tabindex="0">Browse</span><br>
      </p>
    </div>

  `,
  beforeAddFile (e) {
  	$('#allImages').html('');
  }
});


    </script>


@endsection
