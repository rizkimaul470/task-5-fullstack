@extends('layout.dashboard')

@section('title', 'Create Categories')

@section('main')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Categories</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
            <div class="row mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <form>
                                    <div class="input-group mb-3">
                                        <input id="nameForm" type="text" name="name" class="form-control" placeholder="Category Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a onclick="createCategory()" class="btn btn-primary btn-block">Create Category</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready( () => {
            createCategory = () => {
                let token = `{{ Cookie::get('access_token') }}`;

                $.ajax({
                    url: '/api/v1/categories/create',
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: 'application/json',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer "+token);
                    },
                    data: JSON.stringify({
                        name: $('#nameForm').val(),
                    }),
                }).done( (response) => {
                    window.alert(response.message);
                }).fail( (error) => {
                    console.log(error);
                    window.alert(error.responseJSON.message);
                });
            }
        });
    </script>
@endsection