@extends('frontend.Auth.layouts.app')

@section('main')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center fw-bold">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form id="registerForm">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirm_password" class="form-label">{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="password_confirmation" required>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ url('login') }}" class="text-dark">{{ __('Already have an account? Login') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById("registerForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return;
            }

            try {
                const response = await fetch("{{ url('api/register') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        name,
                        email,
                        password,
                        password_confirmation: confirmPassword
                    })
                });

                const data = await response.json();

                if (response.ok && data.token) {
                    localStorage.setItem("token", data.token);
                    window.location.href = "{{ url('/') }}"; // redirect to homepage or dashboard
                } else {
                    const error = data.message || Object.values(data.errors || {}).flat().join(", ") ||
                        "Registration failed";
                    alert(error);
                }

            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again later.');
            }
        });
    </script>
@endsection
