@extends('layout.dashboard')

@section('title', 'Show Article')

@section('css')
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/cqgh3hqnsj8hp4ebyxgxqzd4t2s9r4zlx59egrxq33l0btqp/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('main')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Articles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Articles</li>
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
                        @if ($articles != "not found")
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th class="align-middle">Title</th>
                                        {{-- <th class="align-middle">Content</th> --}}
                                        <th class="align-middle">Image</th>
                                        {{-- <th class="align-middle">Publisher</th> --}}
                                        <th class="align-middle">Category</th>
                                        <th colspan="2" class="align-middle">Update</th>
                                        <th class="align-middle">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $data)
                                        <tr class="text-center">
                                            <td>{{ $data->title }}</td>
                                            {{-- <td>{{ $data->content }}</td> --}}
                                            <td><img class="img-fluid" style="max-width:40%;" src="{{ url('/public') }}/images/{{ $data->image }}"/></td>
                                            {{-- <td class="align-middle">{{ $data->username }}</td> --}}
                                            <td class="align-middle">{{ $data->categoryname }}</td>
                                            <td class="align-middle">
                                                <button id="btnUpdate" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="setData('{{ $data->id }}', '{{ $data->title }}', `{{ $data->content }}`, '{{ $data->image }}', '{{ $data->category_id }}')">Content</button>
                                            </td>
                                            <td class="align-middle">
                                                <button id="btnUpdateImage" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateImage" onclick="setImageData('{{ $data->id }}')">Image</button>
                                            </td>
                                            <td class="align-middle"><button class="btn btn-sm btn-danger" onclick="deleteData({{ $data->id }})">Delete</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            Not Found
                        @endif
                        @if ($articles != "not found")
                            <div class="card-footer clearfix">
                                {{ $articles->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Content -->
    <div id="updateModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Update Data</h5>
                </div>
                <div class="modal-body">
                    <form id="updateForm" method="PUT" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <input id="titleForm" class="form-control" type="text" name="title" placeholder="Title">
                        </div>
                        <div class="input-group mb-3">
                            <textarea id="tiny" class="form-control" name="content"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <input id="categoryForm" class="form-control" type="text" name="category_id" placeholder="Category ID">
                        </div>
                    </form>
                    <input id="newsId" type="hidden" name="id" value=""/>
                </div>
                <div class="modal-footer">
                    <button id="saveModal" type="button" class="btn btn-primary" onclick="updateData()">Save changes</button>
                    <button id="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Image -->
    <div id="updateImage" class="modal fade" tabindex="-1" aria-labelledby="exampleImageLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleImageLabel">Update Image</h5>
                </div>
                <div class="modal-body">
                    <form id="updateImageForm" action="{{ route('articles.create.image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input id="imageID" type="hidden" name="id" value=""/>
                        <div class="input-group mb-3">
                            <input id="imageForm" class="form-control" type="file" name="image"/>
                        </div>
                        <div class="modal-footer">
                            <button id="saveModal" type="submit" class="btn btn-primary">Save changes</button>
                            <button id="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready( () => {

            tinymce.init({
                plugins: 'autoresize',
                selector: 'textarea#tiny',
                plugins: [
                    'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
                    'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
                    'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
                ],
                toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist checklist outdent indent | removeformat | code table help',
                resize: false,
                menubar: false,
            });

            setData = (id, title, content, image, category_id) => {
                $('#titleForm').val(title);
                tinymce.activeEditor.setContent(content);
                $('#newsId').val(id);
                $('#categoryForm').val(category_id);
            }

            setImageData = (id) => {
                $('#imageID').val(id);
            }

            updateData = () => {
                let token = `{{ Cookie::get('access_token') }}`;
                $.ajax({
                    url: '/api/v1/articles/update',
                    type: 'PUT',
                    dataType: 'JSON',
                    contentType: 'application/json',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer "+token);
                    },
                    data: JSON.stringify({
                        id: $('#newsId').val(),
                        title: $('#titleForm').val(),
                        content: tinymce.activeEditor.getContent(),
                        category_id: $('#categoryForm').val(),
                    }),
                }).done( (response) => {
                    window.alert(response.message);
                    window.location = '{{ route("articles.show") }}';
                }).fail( (error) => {
                    console.log(error);
                    window.alert(error.responseJSON.message);
                });
            }

            deleteData = (id) => {
                let token = `{{ Cookie::get('access_token') }}`;
                $.ajax({
                    url: '/api/v1/articles/delete',
                    type: 'DELETE',
                    dataType: 'JSON',
                    contentType: 'application/json',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer "+token);
                    },
                    data: JSON.stringify({
                        id: id,
                    }),
                }).done( (response) => {
                    window.alert(response.message);
                    window.location = '{{ route("articles.show") }}';
                }).fail( (error) => {
                    window.alert(error.responseJSON.message);
                });
            }

        });
    </script>
@endsection