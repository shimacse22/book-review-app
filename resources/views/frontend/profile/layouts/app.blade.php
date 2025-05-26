<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review App</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
                    <a href="#" onclick="logout()" class="text-white">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white" id="welcomeText">
                        Loading...
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img id="userImage" src="/images/default-user.jpg" class="img-fluid rounded-circle"
                                width="100" height="100" alt="User Image">
                        </div>
                        <div class="h5">
                            <strong id="userName">-</strong>
                            <p class="h6 mt-2 text-muted" id="userReviewCount">0 Reviews</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mt-3">
                    <div class="card-header text-white bg-secondary">Navigation</div>
                    <div class="card-body sidebar">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a href="/profile" class="nav-link">Profile</a></li>
                            <li class="nav-item"><a href="/my-reviews" class="nav-link">My Reviews</a></li>
                            <li class="nav-item"><a href="/change-password" class="nav-link">Change Password</a></li>
                            <li class="nav-item"><a href="#" onclick="logout()" class="nav-link">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Load user profile via API --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const token = localStorage.getItem("token");

            if (!token) {
                alert("Not logged in. Redirecting to login.");
                window.location.href = "/login";
                return;
            }

            fetch("/api/profile", {
                    method: "GET",
                    headers: {
                        "Authorization": "Bearer " + token,
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data) {
                        const user = data.data;
                        document.getElementById("welcomeText").textContent = `Welcome, ${user.name}`;
                        document.getElementById("userName").textContent = user.name;
                        document.getElementById("userReviewCount").textContent =
                            `${user.reviews_count || 0} Reviews`;
                        document.getElementById("userImage").src = user.image ?
                            `/storage/${user.image}` :
                            "/images/default-user.jpg";
                    } else {
                        alert("Could not load profile.");
                        window.location.href = "/login";
                    }
                })
                .catch(error => {
                    console.error("Error loading profile:", error);
                    alert("Error fetching profile. Redirecting...");
                    window.location.href = "/login";
                });
        });

        function logout() {
            const token = localStorage.getItem("token");
            if (!token) return;

            fetch("/api/logout", {
                method: "GET",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Accept": "application/json"
                }
            }).then(() => {
                localStorage.removeItem("token");
                window.location.href = "/login";
            }).catch(() => {
                localStorage.removeItem("token");
                window.location.href = "/login";
            });
        }
    </script>
</body>

</html>
