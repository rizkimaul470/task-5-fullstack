@extends('layout.dashboard')

@section('title', 'Welcome')

@section('main')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Welcome, {{ Auth::user()->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Welcome</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection