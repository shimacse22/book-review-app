<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-fluid shadow-lg header bg-primary text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 m-0"><a href="index.html" class="text-white text-decoration-none">Book Review App</a></h1>
                <div class="d-flex align-items-center navigation">

                    <button onclick="logout()" class="btn btn-info">Logout</button>

                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">Books</h2>
                    <a href="#" class="text-dark" id="clear-btn">Clear</a>
                </div>

                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-11">
                                <input type="text" class="form-control form-control-lg" placeholder="Search by title"
                                    id="search-input">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-primary btn-lg w-100" id="search-btn">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div id="book-list" class="row mt-4"></div>

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#" id="prev-page">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#" id="next-page">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        const bookList = document.getElementById('book-list');
        const prevPageButton = document.getElementById('prev-page');
        const nextPageButton = document.getElementById('next-page');
        const searchInput = document.getElementById('search-input');
        const searchBtn = document.getElementById('search-btn');
        const clearBtn = document.getElementById('clear-btn');

        let currentPage = 1;
        let searchQuery = '';

        // Function to fetch books data from API
        function fetchBooks() {
            let url = `/api/books?page=${currentPage}`;
            if (searchQuery) {
                url += `&search=${searchQuery}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    displayBooks(data.data);
                    updatePagination(data);
                })
                .catch(error => console.error('Error fetching books:', error));
        }

        // Function to display books in the UI
        function displayBooks(books) {
            bookList.innerHTML = ''; // Clear existing books
            books.forEach(book => {
                const rating = parseFloat(book.rating) || 0;
                const reviewCount = book.reviews ? book.reviews.length : 0;
                const imageUrl = book.cover_image ?
                    (book.cover_image.startsWith('http') ?
                        book.cover_image :
                        `/storage/${book.cover_image}`) :
                    '/images/book07.jpg';

                const bookCard = `
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card border-0 shadow-lg">
                         <a href="/books/${book.id}"><img src="${imageUrl}" alt="${book.title}" class="card-img-top" onerror="this.onerror=null;this.src='/images/book07.jpg';"></a>
                            <div class="card-body">
                                <h3 class="h5 heading mb-1"><a href="#" class="text-dark text-decoration-none">${book.title}</a></h3>
                                <p class="text-muted mb-2">by ${book.author}</p>
                                <div class="d-flex align-items-center">
                                    <span class="me-2 fw-bold">${rating.toFixed(1)}</span>
                                    <div class="d-inline-flex">
                                        ${[...Array(5)].map((_, i) =>
                                            `<i class="fa fa-star ${i < Math.round(rating) ? 'text-primary' : 'text-muted'}" aria-hidden="true"></i>`
                                        ).join('')}
                                    </div>
                                    <span class="ms-2 text-muted">(${reviewCount} Reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                bookList.innerHTML += bookCard;
            });
        }

        // Update pagination buttons
        function updatePagination(data) {
            prevPageButton.disabled = !data.prev_page_url;
            nextPageButton.disabled = !data.next_page_url;

            prevPageButton.onclick = () => {
                if (data.prev_page_url) {
                    currentPage--;
                    fetchBooks();
                }
            };

            nextPageButton.onclick = () => {
                if (data.next_page_url) {
                    currentPage++;
                    fetchBooks();
                }
            };
        }

        // Search functionality
        searchBtn.onclick = () => {
            searchQuery = searchInput.value;
            currentPage = 1;
            fetchBooks();
        };

        // Clear search functionality
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default anchor link behavior
            searchInput.value = ''; // Clear the search input
            searchQuery = ''; // Reset the search query
            currentPage = 1; // Reset to the first page
            fetchBooks(); // Fetch the books without any search filter
        });

        // Initial fetch of books
        fetchBooks();

        function logout() {
            const token = localStorage.getItem("token");

            fetch("/api/logout", {
                method: "GET",
                headers: {
                    "Authorization": "Bearer " + token
                }
            }).finally(() => {
                localStorage.removeItem("token");
                window.location.href = "/login";
            });
        }
    </script>
</body>

</html>
