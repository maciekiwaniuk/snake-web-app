@extends('layouts.layout')

@section('title')
    Akcje
@endsection


@section('content')

    <div class="col-12
                p-3
                mt-0 mt-sm-2 mt-md-3 mt-lg-4
                border border-2 border-success
                bg-gradient-to-left border-radius-15">


                <div class="col-8 mx-auto text-center">

                    <form method="POST" action="{{ route('actions.load-progress') }}">
                        @csrf
                        <label class="mb-2 fs-4">Wczytaj postęp osiągnięty w grze z pliku</label>
                        <input type="file" name="load-progress-file" id="load-progress-file" class="form-control">
                    </form>

                </div>

    </div>

    <script>


        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            $('#load-progress-file').change(function(event) {
                event.preventDefault();

                var file = document.getElementById('load-progress-file').files[0];
                var formData = new FormData();

                formData.append('progressFile', file);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: 'POST',
                    url:'{{ route("actions.load-progress") }}',
                    data: formData,
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if ( response.result.success ) {
                            toastr.success(response.result.message);
                        } else {
                            toastr.error(response.result.message);
                        }
                    },
                });
            });

        });






    </script>

@endsection

{{-- // $(document).ready(function() {
    //     FilePond.setOptions({
    //         labelIdle: 'Przeciągnij i upuść lub <span class="filepond--label-action">wybierz</span> pliki',
    //         labelInvalidField: 'Nieprawidłowe pliki',
    //         labelFileWaitingForSize: 'Pobieranie rozmiaru',
    //         labelFileSizeNotAvailable: 'Nieznany rozmiar',
    //         labelFileLoading: 'Wczytywanie',
    //         labelFileLoadError: 'Błąd wczytywania',
    //         labelFileProcessing: 'Przesyłanie',
    //         labelFileProcessingComplete: 'Przesłano',
    //         labelFileProcessingAborted: 'Przerwano',
    //         labelFileProcessingError: 'Przesyłanie nie powiodło się',
    //         labelFileProcessingRevertError: 'Coś poszło nie tak',
    //         labelFileRemoveError: 'Nieudane usunięcie',
    //         labelTapToCancel: 'Anuluj',
    //         labelTapToRetry: 'Ponów',
    //         labelTapToUndo: 'Cofnij',
    //         labelButtonRemoveItem: 'Usuń',
    //         labelButtonAbortItemLoad: 'Przerwij',
    //         labelButtonRetryItemLoad: 'Ponów',
    //         labelButtonAbortItemProcessing: 'Anuluj',
    //         labelButtonUndoItemProcessing: 'Cofnij',
    //         labelButtonRetryItemProcessing: 'Ponów',
    //         labelButtonProcessItem: 'Prześlij',
    //         labelMaxFileSizeExceeded: 'Plik jest zbyt duży',
    //         labelMaxFileSize: 'Dopuszczalna wielkość pliku to {filesize}',
    //         labelMaxTotalFileSizeExceeded: 'Przekroczono łączny rozmiar plików',
    //         labelMaxTotalFileSize: 'Łączny rozmiar plików nie może przekroczyć {filesize}',
    //         labelFileTypeNotAllowed: 'Niedozwolony rodzaj pliku',
    //         fileValidateTypeLabelExpectedTypes: 'Oczekiwano {allButLastType} lub {lastType}',
    //         imageValidateSizeLabelFormatError: 'Nieobsługiwany format obrazu',
    //         imageValidateSizeLabelImageSizeTooSmall: 'Obraz jest zbyt mały',
    //         imageValidateSizeLabelImageSizeTooBig: 'Obraz jest zbyt duży',
    //         imageValidateSizeLabelExpectedMinSize: 'Minimalne wymiary obrazu to {minWidth}×{minHeight}',
    //         imageValidateSizeLabelExpectedMaxSize: 'Maksymalna wymiary obrazu to {maxWidth}×{maxHeight}',
    //         imageValidateSizeLabelImageResolutionTooLow: 'Rozdzielczość jest zbyt niska',
    //         imageValidateSizeLabelImageResolutionTooHigh: 'Rozdzielczość jest zbyt wysoka',
    //         imageValidateSizeLabelExpectedMinResolution: 'Minimalna rozdzielczość to {minResolution}',
    //         imageValidateSizeLabelExpectedMaxResolution: 'Maksymalna rozdzielczość to {maxResolution}'
    //     });
    //     FilePond.parse(document.body);
    //     FilePond.registerPlugin(FilePondPluginFileEncode);


    //     $('#load-progress-file').on('FilePond:addfile', function(event) {

    //         var formData = new FormData();

    //         // function test() {
    //         //     var files = $('.filePond').filepond('getFiles');
    //         //     $(files).each(function (index) {
    //         //         console.log(files[index].fileExtension);
    //         //     });
    //         // }

    //         var file = $('#load-progress-file').filepond('getFiles');

    //         console.log(file[0]);

    //         // const dataURL = item.getFileEncodeDataURL();
    //         // const base64String = item.getFileEncodeBase64String();

    //         formData.append('file', file[0]);
    //         formData.append('_token', '{{ csrf_token() }}');

    //         $.ajax({
    //             type: 'POST',
    //             url:'{{ route("actions.load-progress") }}',
    //             data: formData,
    //             dataType: 'json',
    //             enctype: 'multipart/form-data',
    //             contentType: false,
    //             processData: false,
    //             success: function(response) {
    //                 if ( response.result.success ) {
    //                     toastr.success(response.result.message);
    //                 } else {
    //                     toastr.error(response.result.message);
    //                 }
    //             },
    //         });
    //     });

    // }); --}}




