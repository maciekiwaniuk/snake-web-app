@extends('layouts.layout')

@section('title')
    Ustawienia
@endsection

@push('assets')
    <!-- Dropify fonts -->
    <link href="{{ asset('assets/plugins/dropify/fonts/dropify.eot') }}" rel="preconnect">
    <link href="{{ asset('assets/plugins/dropify/fonts/dropify.svg') }}" rel="preconnect">
    <link href="{{ asset('assets/plugins/dropify/fonts/dropify.ttf') }}" rel="preconnect">
    <link href="{{ asset('assets/plugins/dropify/fonts/dropify.woff') }}" rel="preconnect">
    <!-- END Dropify fonts -->
@endpush

@push('css')
    <!-- Dropify CSS -->
    <link href="{{ asset('assets/plugins/dropify/css/dropify.css') }}" type="text/css" rel="stylesheet">

    <!-- Options page CSS -->
    <link href="{{ asset('css/pages/options.css') }}" type="text/css" rel="stylesheet">
@endpush

@push('js.header')
    <!-- Dropify JS -->
    <script src="{{ asset('assets/plugins/dropify/js/dropify.js') }}"></script>

    <!-- BlockUI JS -->
    <script src="{{ asset('assets/plugins/jQueryBlockUI/jquery.blockUI.js') }}"></script>
@endpush


@section('content')

    <div class="col-12
                p-3
                mt-1 mt-sm-2 mt-md-3 mt-lg-4
                border border-2 border-success
                bg-gradient-to-left border-radius-15">


                <div class="accordion" id="optionsAccordion">

                    <!-- Avatar -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingAvatar">
                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAvatar" aria-expanded="false" aria-controls="collapseAvatar">
                                <strong>Awatar</strong>
                            </button>
                        </h2>
                        <div id="collapseAvatar" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="awatar") collapse show @else collapse @endif" aria-labelledby="headingAvatar" data-bs-parent="#optionsAccordion">
                            <div class="accordion-body text-center">

                                <form id="avatarForm" method="POST" action="{{ route('options.avatar-change') }}">
                                    @csrf
                                    <input type="file" name="avatar" id="avatar" class="dropify" data-default-file="{{ Auth::user()->avatar }}"/>
                                </form>

                                <button class="d-block d-md-none btn-md fs-4 mx-auto mt-2
                                               bg-orangeyellow border-radius-15 border border-2 border-dark" id="delete_avatar_xs">Usuń awatar</button>

                            </div>
                        </div>
                    </div>



                    <!-- Password -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPassword">
                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword">
                                <strong>Hasło</strong>
                            </button>
                        </h2>
                        <div id="collapsePassword" class="accordion-collapse @if(isset($selected) && $selected=="haslo") collapse show @else collapse @endif" aria-labelledby="headingPassword" data-bs-parent="#optionsAccordion">
                            <div class="bg-accordion-body accordion-body">


                                @if ($errors->password->any())
                                    <div class="col-12 col-sm-8 col-md-6
                                                mx-auto text-center mb-3 p-2 pb-3
                                                border border-2 border-danger
                                                border-radius-15 bg-error">
                                        @foreach ($errors->password->all() as $error)
                                            <div class="invalid-feedback d-block">
                                                <strong>• {{ $error }}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if (session('password_success'))
                                    <div class="col-12 col-sm-10 mx-auto
                                                text-center mb-3 p-2 pb-3
                                                border border-2 border-success
                                                border-radius-15 bg-complete">
                                                <div class="valid-feedback d-block">
                                                    <strong>• {{ session('password_success') }}</strong>
                                                </div>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('options.password-change') }}" class="row">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-12 col-md-9 col-lg-7 mx-auto">
                                        <label for="password">Aktualne hasło</label>
                                        <input type="password" name="old_password" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-9 col-lg-7 mx-auto">
                                        <label for="new_password" class="mt-2">Nowe hasło</label>
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-9 col-lg-7 mx-auto">
                                        <label for="confirm_password" class="mt-2">Powtórz nowe hasło</label>
                                        <input type="password" name="new_password_confirmation" class="form-control" required>
                                    </div>


                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-sm fs-4 mt-3
                                                                     border border-2 border-dark
                                                                     border-radius-15 bg-orangeyellow"
                                        >Zmień hasło</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>



                    <!-- E-mail -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEmail">
                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmail" aria-expanded="false" aria-controls="collapseEmail">
                                <strong>E-mail</strong>
                            </button>
                        </h2>
                        <div id="collapseEmail" class="accordion-collapse @if(isset($selected) && $selected=="email") collapse show @else collapse @endif" aria-labelledby="headingEmail" data-bs-parent="#optionsAccordion">
                            <div class="bg-accordion-body accordion-body">


                                @if ($errors->email->any())
                                    <div class="col-12 col-sm-8 col-md-6
                                                mx-auto text-center mb-3 p-2 pb-3
                                                border border-2 border-danger
                                                border-radius-15 bg-error">
                                        @foreach ($errors->email->all() as $error)
                                            <div class="invalid-feedback d-block">
                                                <strong>• {{ $error }}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif


                                @if (session('email_success'))
                                    <div class="col-12 col-sm-10 mx-auto
                                                text-center mb-3 p-2 pb-3
                                                border border-2 border-success
                                                border-radius-15 bg-complete">
                                                <div class="valid-feedback d-block">
                                                    <strong>• {{ session('email_success') }}</strong>
                                                </div>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('options.email-change') }}" class="row">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-12 col-md-9 col-lg-7 mx-auto">
                                        <label for="old_password">Aktualne hasło</label>
                                        <input type="password" name="old_password" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-9 col-lg-7 mx-auto">
                                        <label for="new_email" class="mt-2">Nowy email</label>
                                        <input type="text" name="new_email" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-9 col-lg-7 mx-auto">
                                        <label for="new_email_confirmation" class="mt-2">Powtórz nowy email</label>
                                        <input type="text" name="new_email_confirmation" class="form-control" required>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-sm fs-4 mt-3
                                                                     border border-2 border-dark
                                                                     border-radius-15 bg-orangeyellow"
                                        >Zmień email</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>



                    <!-- Others -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingActions">
                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActions" aria-expanded="false" aria-controls="collapseActions">
                                <strong>Inne</strong>
                            </button>
                        </h2>
                        <div id="collapseActions" class="accordion-collapse @if(isset($selected) && $selected=="inne") collapse show @else collapse @endif" aria-labelledby="headingActions" data-bs-parent="#optionsAccordion">
                            <div class="bg-accordion-body accordion-body">

                                <!-- Account status button -->
                                <button type="button" class="btn btn-primary border border-2 border-dark" data-bs-toggle="modal" data-bs-target="#accountStatusModal">
                                    Status konta
                                  </button>

                                <!-- Account status modal -->
                                <div class="modal fade" id="accountStatusModal" tabindex="-1" aria-labelledby="accountStatusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border border-3 border-dark">

                                            <div class="modal-body bg-accordion-body">
                                                <div class="text-center mb-3">
                                                    <h3>Status konta</h3>
                                                </div>

                                                <hr>

                                                <div class="text-start fs-4">
                                                    <div>
                                                        Konto utworzone: {{ Auth::user()->created_at }}
                                                    </div>

                                                    <div>
                                                        E-mail zweryfikowany:
                                                        @if(Auth::user()->email_verified_at != null)
                                                            <i class="bi bi-check-circle text-success fs-3"></i>
                                                        @else
                                                            <i class="bi bi-x-circle text-danger fs-2"></i>
                                                            <button id="verifyEmailButton" class="btn btn-success border border-2 border-dark ms-1">Zweryfikuj e-mail</button>
                                                        @endif
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="text-center mt-3">
                                                    <button type="button" class="btn btn-secondary border border-2 border-dark" data-bs-dismiss="modal">Zamknij</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Delete account button -->
                                <button type="button" id="deleteAccountButton" class="btn btn-danger border border-2 border-dark ms-2" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    Usuń konto
                                </button>

                                <!-- Delete account modal -->
                                <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border border-3 border-danger">

                                            <div class="modal-body bg-accordion-body">

                                                <div class="text-start">
                                                    Usunięcie konta jest czynnością
                                                    <strong class="text-danger">permanentną</strong> oraz <strong class="text-danger">nieodwracalną.</strong>
                                                    Zastanów się czy na pewno chcesz to zrobić!
                                                </div>

                                                <hr>

                                                <form method="POST" action="{{ route('options.account-delete') }}" class="row">
                                                    @csrf
                                                    <div class="col-12 mb-3">
                                                        <label for="old_password">Aktualne hasło</label>
                                                        <input type="password" id="delete_account_password" name="old_password" class="form-control">
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-around">
                                                        <button type="button" class="btn btn-success border border-2 border-dark" data-bs-dismiss="modal">Anuluj</button>
                                                        <button id="confirmDeleteAccountButton" type="submit" class="btn btn-danger border border-2 border-dark">Usuń konto</button>
                                                    </div>

                                                </form>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!-- Logout from game on all devices -->
                                <button type="button" id="logoutFromGameButton" class="btn btn-primary border border-2 border-dark ms-0 ms-md-2 mt-2 mt-md-0">
                                    Wyloguj z gry na wszystkich urządzeniach
                                </button>



                            </div>
                        </div>
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
                    // Timer to unblock screen
                    $.unblockUI();
                }, 400);
            }

            var dropifyOptions = {
                'messages': {
                    'default' : '',
                    'replace' : '',
                    'remove' :  'Usuń',
                    'error' :   'Upppsss, coś poszło nie tak.'
                },
                'tpl': {
                    'message': '<div class="dropify-message"><span class="file-icon" /> <p class="fs-4">Wczytaj obrazek, który chcesz ustawić jako awatar.</p></div>',
                }
            };

            var dropify = $('.dropify').dropify(dropifyOptions);

            dropify.change(function(event){
                event.preventDefault();

                var file = document.getElementById('avatar').files[0];
                var formData = new FormData();

                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: 'POST',
                    url:'{{ route("options.avatar-change") }}',
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
                                // avatar icon refresh
                                d = new Date();
                                $('#user_avatar').attr('src', response.avatarPath+'?'+d.getTime());
                            }, 400);
                        } else {
                            blockUI();
                            setTimeout(function () {
                                toastr.error(response.result.message);
                            }, 400);
                        }
                    },
                });
            });

            $('#delete_avatar_xs').on('click', function() {
                $('.dropify-clear').trigger('click');
            });

            $('.dropify-clear').on('click', function() {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("options.avatar-delete") }}',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response){
                        if ( response.result.success ) {
                            blockUI();
                            setTimeout(function () {
                                toastr.success(response.result.message);
                            }, 400);
                        }
                        d = new Date();
                        $('#user_avatar').attr('src', response.result.avatarPath+'?'+d.getTime());
                    },
                });
            })


            $('#confirmDeleteAccountButton').on('click', function() {
                event.preventDefault();

                var password = $('#delete_account_password').val();

                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("options.account-delete") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        password: password,
                    },
                    success: function (response) {
                        if (response.result.error) {
                            blockUI();
                            setTimeout(function () {
                                toastr.error(response.result.message);
                            }, 400);
                        } else {
                            window.location.replace(response.result.url);
                        }
                    },
                });
            });

            $('#logoutFromGameButton').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("options.logout-from-game") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.result.success) {
                            blockUI();
                            setTimeout(function () {
                                toastr.success(response.result.message);
                            }, 400);
                        }
                    },
                });
            });

            $('#verifyEmailButton').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("verification.send") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        blockUI();
                        setTimeout(function () {
                            toastr.success(response.result.message);
                        }, 400);
                    }
                });
            });

        });
    </script>

@endsection

