@extends('Layouts.Admin.app')


@section('content')
    @push('customCss')
        <link href="{{ asset('admin/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
            type="text/css" />
    @endpush
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $info->page_title }}</a></li>
                </ol>
            </div>
            <h4 class="page-title">{{ $info->page_title }}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.category.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" id="category_name"
                                class="form-control @error('category_name')
                                        is-invalid
                                        @enderror"
                                placeholder="Category Name" name="category_name">
                            @error('category_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category_slug" class="form-label">Category Slug</label>
                            <input type="text"
                                class="form-control @error('category_slug')
                                        is-invalid
                                        @enderror"
                                placeholder="Category Slug" name="category_slug" id="category_slug">
                            @error('category_slug')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">

                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input d-none" name="status" checked
                                    value="0">
                                <input type="checkbox" class="form-check-input" name="status" value="1">
                                <label class="form-check-label" for="">Status</label>
                            </div>
                        </div>
                        <button class="btn btn-primary waves-effect waves-light">Submit</button>
                    </form>
                </div>

            </div> <!-- end card body-->
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ $info->all_data }}</h4>
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ $item->category_slug }}</td>
                                    <td>
                                        @if ($item->status === 1)
                                            <span class="badge bg-success rounded-pill">Success</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill">in-active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="" class="edit"><i class="material-symbols-outlined">edit</i></a>
                                        <span class="delete"><i class="material-symbols-outlined">delete</i></span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <!-- end row-->
    </div>
    @push('customJs')
        <!-- Datatable js-->
        <script src="{{ asset('admin/assets/js/pages/datatables.init.js') }}"></script>

        <!-- datatable js start -->
        <script src="{{ asset('admin/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>

        <script>
            $('#category_name').on('keyup', function() {
                categoryName = $(this).val();
                slug = categoryName.trim().toLowerCase().replace(/[^a-zA-Z0-9]+/g, '-');
                $('#category_slug').val(slug);
            })
        </script>
    @endpush
@endsection
