@extends('layouts.layout')

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
    <!-- END Dropify CSS -->
@endpush

@push('js.header')
    <!-- Dropify JS -->
    <script src="{{ asset('assets/plugins/dropify/js/dropify.js') }}"></script>
    <!-- END Dropify JS -->
@endpush

@push('js.body')
    <script src="{{ asset('js/options/index.js') }}" type="module"></script>
@endpush


@section('title')
    Ustawienia
@endsection


@section('content')

    <div class="col-12
                mx-auto
                mx-5 mt-2 mb-3 fs-3 pt-2 pb-3 ps-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">


                <div class="accordion" id="optionsAccordion">

                    <!-- Awatar -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingAvatar">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAvatar" aria-expanded="false" aria-controls="collapseAvatar">
                                Awatar
                            </button>
                        </h2>
                        <div id="collapseAvatar" class="accordion-collapse @if(isset($selected) && $selected=="awatar") collapse show @else collapse @endif" aria-labelledby="headingAvatar" data-bs-parent="#optionsAccordion">
                            <div class="accordion-body text-center">

                                <form id="avatarForm" method="POST" action="{{ route('options.avatar-change') }}">
                                    @csrf
                                    <input type="file" name="avatar" id="avatar" class="dropify" data-default-file="../{{ Auth::user()->avatar }}"/>
                                </form>

                                <button class="d-block d-sm-none mx-auto col-4 mt-2
                                               btn btn-primary" id="delete_avatar_xs">Usuń awatar</button>

                            </div>
                        </div>
                    </div>



                    <!-- Hasło -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPassword">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword">
                                Hasło
                            </button>
                        </h2>
                        <div id="collapsePassword" class="accordion-collapse @if(isset($selected) && $selected=="haslo") collapse show @else collapse @endif" aria-labelledby="headingPassword" data-bs-parent="#optionsAccordion">
                            <div class="accordion-body">


                                @forelse ($errors->password->all() as $error)
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $error }}</strong>
                                    </div>
                                @empty
                                @endforelse


                                @if (session('password_success'))
                                    <div class="valid-feedback d-block">
                                        <strong>{{ session('password_success') }}</strong>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('options.password-change') }}">
                                    @csrf
                                    @method('PUT')
                                    <label for="password">Aktualne hasło</label>
                                    <input type="password" name="old_password"> <br>

                                    <label for="new_password">Nowe hasło</label>
                                    <input type="password" name="new_password"> <br>

                                    <label for="confirm_password">Powtórz nowe hasło</label>
                                    <input type="password" name="new_password_confirmation"> <br>

                                    <button type="submit">Zmień hasło</button>
                                </form>


                            </div>
                        </div>
                    </div>



                    <!-- Email -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEmail">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmail" aria-expanded="false" aria-controls="collapseEmail">
                                Email
                            </button>
                        </h2>
                        <div id="collapseEmail" class="accordion-collapse @if(isset($selected) && $selected=="email") collapse show @else collapse @endif" aria-labelledby="headingEmail" data-bs-parent="#optionsAccordion">
                            <div class="accordion-body">


                                @forelse ($errors->email->all() as $error)
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $error }}</strong>
                                    </div>
                                @empty
                                @endforelse


                                @if (session('email_success'))
                                    <div class="valid-feedback d-block">
                                        <strong>{{ session('email_success') }}</strong>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('options.email-change') }}">
                                    @csrf
                                    @method('PUT')
                                    <label for="old_password">Aktualne hasło</label>
                                    <input type="password" name="old_password"> <br>

                                    <label for="new_email">Nowy email</label>
                                    <input type="text" name="new_email"> <br>

                                    <label for="new_email_confirmation">Powtórz nowy email</label>
                                    <input type="text" name="new_email_confirmation"> <br>

                                    <button type="submit">Zmień email</button>
                                </form>


                            </div>
                        </div>
                    </div>



                    <!-- Inne -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingActions">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActions" aria-expanded="false" aria-controls="collapseActions">
                                Inne
                            </button>
                        </h2>
                        <div id="collapseActions" class="accordion-collapse @if(isset($selected) && $selected=="inne") collapse show @else collapse @endif" aria-labelledby="headingActions" data-bs-parent="#optionsAccordion">
                            <div class="accordion-body">

                                <!-- Usuń konto przycisk -->
                                <button type="button" id="deleteAccountButton" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    Usuń konto
                                </button>

                                <!-- Usuń konto modal -->
                                <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-body">

                                                <div>
                                                    Usunięcie konta jest czynnością permanentną oraz nieodwracalną.
                                                    Zastanów się czy na pewno chcesz to zrobić!
                                                </div>

                                                <hr>

                                                <div id="deleteAccountMessage" class="invalid-feedback d-block"></div>

                                                <form method="POST" action="{{ route('options.account-delete') }}">
                                                    @csrf
                                                    @method('delete')
                                                    <label for="old_password">Aktualne hasło</label>
                                                    <input type="password" name="old_password"> <br>

                                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Anuluj</button>
                                                    <button type="submit" class="btn btn-danger">Usuń konto</button>
                                                </form>



                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- TOAST SUCCESS -->
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                    <div id="toastNotification" class="toast d-none" role="alert" aria-live="assertive" aria-atomic="true" data-bs-animation="true" data-bs-delay="3000">
                        <div class="toast-body" id="toastNotificationMessage"></div>
                    </div>
                </div>
                <!-- END TOAST-->



    </div>

    <script>
        $(document).ready(function() {
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
                        $('#toastNotificationMessage').html(response.result.message);
                        if ( response.result.success ) {
                            $('#toastNotification').removeClass('toast-error d-none').addClass('toast-success');
                            $('#toastNotification').toast('show');
                            // odświeżenie ikonki awatara
                            d = new Date();
                            $('#user_avatar').attr('src', response.avatarPath+'?'+d.getTime());
                        } else {
                            $('#toastNotification').removeClass('toast-success d-none').addClass('toast-error');
                            $('#toastNotification').toast('show');
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
                            $('#toastNotificationMessage').html(response.result.message);
                            $('#toastNotification').removeClass('toast-error d-none').addClass('toast-success');
                            $('#toastNotification').toast('show');
                        }
                        d = new Date();
                        $('#user_avatar').attr('src', 'assets/images/avatar.png?'+d.getTime());
                    },
                });
            })

            $('#toastNotification').click(function() {
                $('#toastNotification').addClass('d-none');
            });

        });
    </script>

@endsection

