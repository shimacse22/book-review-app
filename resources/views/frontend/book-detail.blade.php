<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .star-rating i {
            font-size: 1rem;
            margin-right: 2px;
        }

        .star-rating {
            position: relative;
            display: inline-block;
            font-size: 1.2rem;
            line-height: 1;
        }

        .back-stars {
            color: #ddd !important;
            /* Light gray for full background stars */
            position: relative;
        }

        .front-stars {
            color: #007bff !important;
            /* Blue for active rating */
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            pointer-events: none;
        }

        .fa-star {
            margin-right: 2px;
        }
        }
    </style>
</head>

<body>
    <div class="container-fluid shadow-lg header">
        <div class="container">
            <div class="d-flex justify-content-between">
                <h1 class="text-center">
                    <a href="{{ url('/') }}" class="h3 text-white text-decoration-none">Book Review App</a>
                </h1>
                <div class="d-flex align-items-center navigation">
                    <a href="{{ url('/login') }}" class="text-white">Login</a>
                    <a href="{{ url('/register') }}" class="text-white ps-2">Register</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <a href="{{ route('books') }}" class="text-decoration-none text-dark">
                    <i class="fa fa-arrow-left"></i> &nbsp; <strong>Back to books</strong>
                </a>

                <div id="loading-message" class="text-muted mt-3">Loading book details...</div>
                <div id="error-message" class="text-danger mt-3" style="display: none;">Book not found.</div>

                <div id="book-detail-content" style="display: none;">
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <img id="book-image" src="" alt="" class="card-img-top">
                        </div>
                        <div class="col-md-8">
                            <h3 class="h2 mb-3" id="book-title"></h3>
                            <div class="h4 text-muted" id="book-author"></div>

                            <div class="star-rating d-inline-flex align-items-center my-2">
                                <span id="book-rating" class="rating-text theme-font theme-yellow me-2"></span>

                                <div class="d-inline-flex" id="book-stars"></div>

                                <span class="theme-font text-muted ms-2" id="review-count"></span>
                            </div>

                            <div class="content mt-3" id="book-description"></div>

                            <hr class="mt-4">
                            <div class="mt-5">
                                <h3>Readers also enjoyed</h3>
                                <div class="row" id="similar-books-container"></div>
                            </div>
                            <div class="col-md-12 pt-2">
                                <hr>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <h3>Reviews</h3>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    Add Review
                                </button>
                            </div>

                            <div id="book-reviews"></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">
                        Add Review for <strong><span id="modal-book-title"></span></strong>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="review-form" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <textarea id="review" class="form-control" rows="5" placeholder="Write your review here"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select id="rating" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-review">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParts = window.location.pathname.split('/').filter(p => p !== "");
            const bookId = urlParts[urlParts.length - 1];
            const token = localStorage.getItem("token");

            const fetchWithAuth = (url) => {
                return fetch(url, {
                    headers: {
                        "Authorization": `Bearer ${token}`
                    }
                });
            };

            // Load Book Details
            fetch(`http://127.0.0.1:8000/api/books/${bookId}`)
                .then(res => {
                    if (!res.ok) throw new Error("Book not found");
                    return res.json();
                })
                .then(response => {
                    const book = response.data;

                    document.getElementById("loading-message").style.display = "none";
                    document.getElementById("book-detail-content").style.display = "block";

                    document.getElementById("book-title").textContent = book.title;
                    document.getElementById("modal-book-title").textContent = book.title;
                    document.getElementById("book-author").textContent = book.author;

                    document.getElementById("book-description").innerHTML = `<p>${book.description}</p>`;
                    document.getElementById("book-image").src = `/storage/${book.cover_image}`;
                    const rating = book.rating;
                    const reviewCount = book.reviews_count;

                    // Set rating text
                    document.querySelector("#book-rating").textContent = rating.toFixed(1);

                    // Set stars
                    const starRatingContainer = document.querySelector("#book-stars");
                    starRatingContainer.innerHTML = `
    ${[...Array(5)].map((_, i) =>
        `<i class="fa fa-star ${i < Math.round(rating) ? 'text-primary' : 'text-muted'}" aria-hidden="true"></i>`
    ).join('')}
`;

                    // Set review count
                    document.querySelector("#review-count").textContent = `(${reviewCount} Reviews)`;

                    const reviewsContainer = document.getElementById("book-reviews");
                    reviewsContainer.innerHTML = book.reviews.length > 0 ?
                        book.reviews.slice(0, 3).map(review => `
                <div class="card border-0 shadow-lg my-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>${review.user.name}</h5>
                        </div>
                        <div class="mb-3 star-rating">
                            <div class="back-stars">
                                <div class="front-stars" style="width: ${(review.rating / 5) * 100}%;">
                                    ${'<i class="fa fa-star"></i>'.repeat(5)}
                                </div>
                                ${'<i class="fa fa-star"></i>'.repeat(5)}
                            </div>
                        </div>
                        <p>${review.review}</p>
                    </div>
                </div>
            `).join('') :
                        `<p class="text-muted">No reviews yet.</p>`;

                    // Load Similar Books
                    fetch(`http://127.0.0.1:8000/api/books/${book.id}/similar`)
                        .then(res => res.json())
                        .then(similarBooks => {
                            const container = document.getElementById("similar-books-container");
                            container.innerHTML = Array.isArray(similarBooks) && similarBooks.length ?
                                similarBooks.slice(0, 3).map(similar => `
                        <div class="col-md-4 mb-4">
                            <a href="/books/${similar.id}" class="text-decoration-none text-dark">
                                <div class="card h-100 shadow-sm border-0">
                                    <img src="/storage/${similar.cover_image}" 
                                        class="card-img-top" 
                                        alt="${similar.title}"
                                        onerror="this.onerror=null; this.src='/images/book07.jpg';">
                                    <div class="card-body">
                                        <h5 class="card-title">${similar.title}</h5>
                                        <p class="card-text text-muted">${similar.author}</p>
                                        <div class="star-rating mb-3">
                                            <div class="back-stars">
                                                <div class="front-stars" style="width: ${(similar.rating / 5) * 100}%;">
                                                    ${'<i class="fa fa-star"></i>'.repeat(5)}
                                                </div>
                                                ${'<i class="fa fa-star"></i>'.repeat(5)}
                                            </div>
                                        </div>
                                        <span class="text-primary small d-block mt-2">View Book</span>
                                    </div>
                                </div>
                            </a>
                        </div>`).join('') :
                                `<p class="text-muted">No similar books found.</p>`;
                        });
                })
                .catch(err => {
                    console.error("Failed to load book:", err);
                    document.getElementById("loading-message").style.display = "none";
                    document.getElementById("error-message").style.display = "block";
                });
            // Submit Review
            document.getElementById('submit-review').addEventListener('click', async function() {
                const reviewText = document.getElementById('review').value.trim();
                const rating = document.getElementById('rating').value;

                if (!token) {
                    alert("Please log in to submit a review.");
                    window.location.href = "/login";
                    return;
                }

                try {
                    const response = await fetch("http://127.0.0.1:8000/api/reviews", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": `Bearer ${token}`
                        },
                        body: JSON.stringify({
                            book_id: bookId,
                            review: reviewText,
                            rating: rating
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || "Failed to submit review.");
                    }

                    alert("Review submitted successfully!");
                    location.reload(); // reload to show the new review
                } catch (error) {
                    console.error(error);
                    alert("Something went wrong. Please try again.");
                }
            });
        });
    </script>

</body>

</html>
