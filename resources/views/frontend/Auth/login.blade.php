@extends('frontend.Auth.layouts.app')

@section('main')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form id="loginForm">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ url('register') }}"
                                class="text-dark">{{ __('Don’t have an account? Register') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById("loginForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            const response = await fetch("{{ url('api/login') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    email,
                    password
                }),
            });

            const data = await response.json();

            if (response.ok && data.data && data.data.token) {
                // ✅ Store the token correctly
                localStorage.setItem("token", data.data.token);
                // ✅ Optionally store user info
                localStorage.setItem("user", JSON.stringify(data.data.user));

                // Redirect to book detail or listing
                window.location.href = "{{ url('/book-review') }}";
            } else {
                const error = data.message || "Login failed";
                alert(error);
            }
        });
    </script>
@endsection
