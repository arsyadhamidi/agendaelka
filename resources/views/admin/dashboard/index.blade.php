@extends('admin.layout.master')
@section('title', 'Dashboard | Agenda Elka')
@section('menuDashboard', 'active')

@section('content')
    @if (Auth()->user()->level_id == '1')
        @include('admin.index')
    @elseif(Auth()->user()->level_id == '3')
        @include('kepala-departemen.index')
    @elseif(Auth()->user()->level_id == '4')
        @include('kaprodi.index')
    @elseif(Auth()->user()->level_id == '5')
        @include('dosen.index')
    @elseif(Auth()->user()->level_id == '6')
        @include('mahasiswa.index')
    @endif
@endsection
