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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">
                            {{ $info->page_title }}</a></li>
                </ol>
            </div>
            <h4 class="page-title">
                @if (isset($row->title))
                    {{ $row->title }}
                @else
                    {{ $info->page_title }}
                @endif
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <form
                        action="@if (isset($row->id)) {{ route($info->form_update, $row->id) }}@else{{ route($info->form_store) }} @endif"
                        method="post">
                        @csrf
                        @if (isset($row))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="title" class="form-label">Category title</label>
                            <input type="text" id="title"
                                class="form-control @error('title')
                                        is-invalid
                                        @enderror"
                                placeholder="Category title" name="title"
                                @if (isset($row->title)) value="{{ $row->title }}" @endif>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Category Slug</label>
                            <input type="text"
                                class="form-control @error('slug')
                                        is-invalid
                                        @enderror"
                                placeholder="Category Slug" name="slug" id="slug"
                                @if (isset($row->slug)) value="{{ $row->slug }}" @endif">
                            @error('slug')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">

                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input d-none" name="status" checked
                                    value="0">
                                <input type="checkbox" class="form-check-input" name="status" value="1"
                                    @if (isset($row->status)) @if ($row->status === 1)
                                    checked @endif
                                    @endif>
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
                    <table class="table dt-responsive nowrap w-100">
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
                            @foreach ($data as $key => $row)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->slug }}</td>
                                    <td>
                                        @if ($row->status === 1)
                                            <span class="badge bg-success rounded-pill">Success</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill">in-active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route($info->form_edit, $row->id) }}" class="edit"><i
                                                class="material-symbols-outlined">edit</i></a>
                                        <a href="{{ route($info->form_destroy, $row->id) }}" class="delete"><i
                                                class="material-symbols-outlined text-danger">delete</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">{{ $data->links() }}</li>
                        </ul>
                    </nav>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <!-- end row-->
    </div>
    @push('customJs')
        <script>
            $('#title').on('keyup', function() {
                categoryName = $(this).val();
                slug = categoryName.trim().toLowerCase().replace(/[^a-zA-Z0-9]+/g, '-');
                $('#slug').val(slug);
            })
        </script>
    @endpush
@endsection
