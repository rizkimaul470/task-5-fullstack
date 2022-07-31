@extends('layout.dashboard')

@section('title', 'Show Categories')

@section('main')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Categories</li>
                        <li class="breadcrumb-item active">Show</li>
                    </ol>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input id="searchForm" type="text" name="table_search" class="form-control float-right" placeholder="Search Title">
                                    <div class="input-group-append">
                                        <button id="searchTitle" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($categories != "not found")
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th class="align-middle">Name</th>
                                        <th class="align-middle">Created By</th>
                                        <th colspan="2" class="align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $data)
                                        <tr class="text-center">
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->username }}</td>
                                            <td class="align-middle">
                                                <button id="btnUpdate" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="setData('{{ $data->id }}', '{{ $data->name }}')">Update</button>
                                            </td>
                                            <td class="align-middle"><button class="btn btn-sm btn-danger" onclick="deleteData(`{{ $data->name }}`)">Delete</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            Not Found
                        @endif
                        @if ($categories != "not found")
                            <div class="card-footer clearfix">
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Update Data</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <form method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="nameForm" class="form-control" type="text" name="name" placeholder="Name">
                        </div>
                        <input type="hidden" id="oldName" value="">
                        <input type="hidden" id="categoryId" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="saveModal" type="button" class="btn btn-primary" onclick="updateData()">Save changes</button>
                    <button id="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready( () => {

            setData = (id, name) => {
                $('#nameForm').val(name);
                $('#oldName').val(name);
                $('#categoryId').val(id);
            }

            updateData = () => {
                let token = `{{ Cookie::get('access_token') }}`;
                $.ajax({
                    url: '/api/v1/categories/update',
                    type: 'PUT',
                    dataType: 'JSON',
                    contentType: 'application/json',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer "+token);
                    },
                    data: JSON.stringify({
                        old_name: $('#oldName').val(),
                        name: $('#nameForm').val(),
                    }),
                }).done( (response) => {
                    window.alert(response.message);
                    window.location = '{{ route("categories.show") }}';
                }).fail( (error) => {
                    console.log(error);
                    window.alert(error.responseJSON.message);
                });
            }

            deleteData = (name) => {
                let token = `{{ Cookie::get('access_token') }}`;
                $.ajax({
                    url: '/api/v1/categories/delete',
                    type: 'DELETE',
                    dataType: 'JSON',
                    contentType: 'application/json',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer "+token);
                    },
                    data: JSON.stringify({
                        name: name.toString(),
                    }),
                }).done( (response) => {
                    window.alert(response.message);
                    window.location = '{{ route("categories.show") }}';
                }).fail( (error) => {
                    window.alert(error.responseJSON.message);
                });
            }

        });
    </script>
@endsection