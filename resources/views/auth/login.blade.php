@extends('layouts.guest')

@section('content')
<div class="container">

    <div class="row justify-content-center mt-5">
        <div class="col-md-6">

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h4 class="text-center mb-4">Login</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        <button class="btn btn-primary w-100">Login</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
