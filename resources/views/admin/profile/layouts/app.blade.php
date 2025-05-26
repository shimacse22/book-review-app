<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review App</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Local CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container-fluid shadow-lg header">
        <div class="container">
            <div class="d-flex justify-content-between">
                <h1 class="text-center">
                    <a href="{{ url('/') }}" class="h3 text-white text-decoration-none">Book Review App</a>
                </h1>
                <div class="d-flex align-items-center navigation">
                    <a href="{{ route('admin.login') }}" class="text-white">Account</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                    <div class="card-header text-white">
                        Welcome, {{ auth()->user()->name }}
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">

                            <div class="mb-3">
                                <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/default-user.jpg') }}"
                                    class="img-fluid rounded-circle" width="100" height="100"
                                    alt="{{ auth()->user()->name }}">
                            </div>

                        </div>
                        <div class="h5 text-center">
                            <strong>{{ auth()->user()->name }}</strong>
                            <p class="h6 mt-2 text-muted">{{ auth()->user()->reviews()->count() }}Reviews</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mt-3">
                    <div class="card-header text-white">Navigation</div>
                    <div class="card-body sidebar">
                        <ul class="nav flex-column">

                            <li class="nav-item">
                                <a href="{{ route('books.index') }}">Books</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('reviews.index') }}">Reviews</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.profile') }}">Profile</a>
                            </li>

                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    {{-- Auto hide the alert after 3 seconds --}}
    <script>
        setTimeout(function() {
            let successAlert = document.getElementById('successMessage');
            if (successAlert) {
                successAlert.style.display = 'none';
            }

            let errorAlert = document.getElementById('errorMessage');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>

</body>

</html>
