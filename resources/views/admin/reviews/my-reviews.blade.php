@extends('admin.profile.layouts.app')

@section('content')
    <div class="col-md-9">

        <div class="card border-0 shadow">
            <div class="card-header  text-white">
                My Reviews
            </div>
            <div class="card-body pb-0">
                <table class="table  table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Book</th>
                            <th>Review</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th width="100">Action</th>
                        </tr>
                    <tbody>
                        <tr>
                            <td>Atomic Habits</td>
                            <td>This seems an excellent book to read.</td>
                            <td>3.0</td>
                            <td>Active</td>
                            <td>
                                <a href="edit-review.html" class="btn btn-primary btn-sm"><i
                                        class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Atomic Habits</td>
                            <td>This seems an excellent book to read.</td>
                            <td>3.0</td>
                            <td>Active</td>
                            <td>
                                <a href="edit-review.html" class="btn btn-primary btn-sm"><i
                                        class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Atomic Habits</td>
                            <td>This seems an excellent book to read.</td>
                            <td>3.0</td>
                            <td>Active</td>
                            <td>
                                <a href="edit-review.html" class="btn btn-primary btn-sm"><i
                                        class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Atomic Habits</td>
                            <td>This seems an excellent book to read.</td>
                            <td>3.0</td>
                            <td>Active</td>
                            <td>
                                <a href="edit-review.html" class="btn btn-primary btn-sm"><i
                                        class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                    </thead>
                </table>
                <nav aria-label="Page navigation ">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
@endsection
