@extends('layouts.auth', ['title' => 'Password Recovery'])

@section('content')
    <div class="row">

        @include('components.auth.cover')

        <div
            class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <form class="was-validated" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <h2>Password Recovery</h2>
                                <p>Enter your email and instructions will sent to you!</p>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bs-tooltip" title="Email" id="basic-addon1">
                                            <i data-feather="at-sign"></i>
                                        </span>
                                        <input type="email" name="email" id="email"
                                            class="form-control maxlength @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="Input Your Email"
                                            aria-describedby="basic-addon1" minlength="5" maxlength="100" required
                                            autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-secondary w-100">RECOVER</button>
                                </div>
                            </div>
                        </form>

                        @include('components.auth.social')

                        @if (Route::has('login'))
                            <div class="col-12">
                                <div class="text-center">
                                    <p class="mb-0">Already have an account ? <a href="{{ route('login') }}"
                                            class="text-warning">Sign In</a></p>
                                </div>
                            </div>
                        @endif

                        @include('components.auth.ontap')

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://accounts.google.com/gsi/client" async defer></script>
@endpush
