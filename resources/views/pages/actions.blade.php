@extends('layouts.layout')

@section('title')
    Akcje
@endsection

@push('js.header')
    <!-- DataTables JS -->
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <!-- END DataTables JS -->

    <!-- BlockUI JS -->
    <script src="{{ asset('assets/plugins/jQuery BlockUI/jquery.blockUI.js') }}"></script>
    <!-- END BlockUI JS -->
@endpush

@push('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet" text="text/css">
    <!-- END DataTables CSS -->
@endpush

@section('content')

    <style>
        .dataTables_filter {
            padding-bottom: 1vh;
            padding-top: 0.5vh;
        }

        #UserProgressTable {
            border: solid black 2px;
        }
    </style>

    <div class="col-12
                p-3
                mt-0 mt-sm-2 mt-md-3 mt-lg-4
                border border-2 border-success
                bg-gradient-to-left border-radius-15">


                <div class="col-12 col-sm-11 col-md-9 col-lg-7
                            mx-auto text-center">

                            <form method="POST" action="{{ route('actions.progress-load') }}">
                                @csrf
                                <label class="mb-2 fs-4">Wczytaj postęp osiągnięty w grze z pliku</label>
                                <input type="file" name="load-progress-file" id="load-progress-file" class="form-control"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="Jeżeli masz problem z wczytaniem postępu w grze, odwiedź zakładkę pomocą.">
                            </form>

                </div>

                <hr>

                <div class="col-12
                            mx-auto text-center">

                            <span class="fs-4"><strong>Zapisane postępy</strong></span>

                            <div class="mt-2">
                                <table id="UserProgressTable" class="table table-primary table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                </div>


    </div>

    <script>


        $(document).ready(function() {

            function blockUI() {
                // Default blockUI code
                $.blockUI({
                    css: {
                        padding: '8px',
                        backgroundColor: 'rgb(198, 234, 108)',
                        border: 'solid black 2px',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                    },
                    message: `<div class="spinner-border text-success" role="status"></div>
                              <div>Trwa wczytywanie...</div>`,
                });
                setTimeout(function () {
                    // Timer to unblock
                    $.unblockUI();
                }, 400);
            }

            // Function to download data to a file
            function download(data, filename, type) {
                var file = new Blob([data], {type: type});
                if (window.navigator.msSaveOrOpenBlob) // IE10+
                    window.navigator.msSaveOrOpenBlob(file, filename);
                else { // Others
                    var a = document.createElement("a"),
                    url = URL.createObjectURL(file);
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    setTimeout(function() {
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    }, 0);
                }
            }



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
                    url:'{{ route("actions.progress-load") }}',
                    data: formData,
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if ( response.result.success ) {
                            blockUI();
                            setTimeout(function () {
                                toastr.success(response.result.message);
                                $('#UserProgressTable').DataTable().ajax.reload();
                            }, 400);
                        } else {
                            setTimeout(function () {
                                toastr.error(response.result.message);
                            }, 300);

                        }
                    },
                });
            });


            // Datatables
            $('#UserProgressTable').DataTable({
                oLanguage: {
                    sUrl: "{{ asset('assets/plugins/DataTables/pl.json') }}"
                },

                drawCallback: function(settings) {
                    $(".delete-button").each(function(index) {
                        $(this).on("click", function(event) {
                            event.preventDefault();

                            let urlToReplace = "{{ route('actions.progress-delete', ['id' => '__ID__']) }}";
                            let URL = urlToReplace.replace('__ID__', $(this).val());

                            $.ajax({
                                type: 'DELETE',
                                url: URL,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: $(this).val(),
                                },
                                success: function(response){
                                    if ( response.result.success ) {
                                        blockUI();
                                        setTimeout(function () {
                                            toastr.success(response.result.message);
                                            $('#UserProgressTable').DataTable().ajax.reload();
                                        }, 400);
                                    }
                                },
                            });
                        });
                    });

                    $(".select-button").each(function(index) {
                        $(this).on("click", function(event) {

                            let urlToReplace = "{{ route('actions.progress-select', ['id' => '__ID__']) }}";
                            let URL = urlToReplace.replace('__ID__', $(this).val());

                            $.ajax({
                                type: 'POST',
                                url: URL,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: $(this).val(),
                                },
                                success: function(response){
                                    if ( response.result.success ) {
                                        blockUI();
                                        setTimeout(function () {
                                            toastr.success(response.result.message);
                                        }, 400);
                                    }
                                },
                            });
                        });
                    });

                    $(".download-button").each(function(index) {
                        $(this).on("click", function(event) {
                            event.preventDefault();

                            let urlToReplace = "{{ route('actions.progress-download', ['id' => '__ID__']) }}";
                            let URL = urlToReplace.replace('__ID__', $(this).val());

                            $.ajax({
                                type: 'POST',
                                url: URL,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: $(this).val(),
                                },
                                success: function(response){
                                    if ( response.result.success ) {
                                        blockUI();
                                        setTimeout(function () {
                                            toastr.success(response.result.message);
                                            download(response.result.data, response.result.filename, 'application/json');
                                        }, 400);
                                    }
                                },
                            });
                        });
                    });

                },


                order: [[ 2, 'desc' ]],
                lengthChange: false,
                info: false,
                serverSide: false,
                ajax: {
                    url: "{{ route('actions.progress-show') }}",
                    type: "GET",
                    datatype: "json",
                    contentType: "application/json",
                },
                columns: [
                    {
                        title: 'Numer',
                        data: "",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        class: 'align-middle',
                    },
                    {
                        title: 'Nazwa pliku',
                        data: 'filename',
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Data dodania',
                        data: 'date',
                        class: 'align-middle',
                    },
                    {
                        title: 'Usuń',
                        data: 'id',
                        render: function(data) {
                            return `<button name="id" value="`+data+`" class="delete-button btn btn-danger btn-sm border border-2 border-dark">
                                        <i class="bi bi-trash-fill text-dark"></i>
                                    </button>`;

                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Pobierz',
                        data: 'id',
                        render: function(data) {
                            return `<button name="id" value="`+data+`" class="download-button btn btn-success btn-sm border border-2 border-dark">
                                        <i class="bi bi-download text-light"></i>
                                    </button>`;

                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Ustaw',
                        data: 'id',
                        render: function(data) {
                            checked = "";
                            currentID = "{{ Auth::user()->user_game_data_id }}";
                            if (currentID.length >= 1 && currentID == data) {
                                checked = "checked";
                            }

                            return `<input type="radio" name="selectedProgress" `+checked+` value="`+data+`" class="select-button form-check-input">`;
                        },
                        class: 'align-middle',
                        orderable: false,
                    },

                ]
            });
        });




    </script>

@endsection
