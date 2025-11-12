@extends('layouts.dashboard')
@section('title', 'Dashboard Page')

@section('content')
    <div class="row">







        @if (auth()->user()->role == 'admin')
            @include('admin.dashboard')
        @else
            @include('user.dashboard')
        @endif

    </div>
@endsection
