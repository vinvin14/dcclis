@extends('interface.main')
@section('page')
    <h1>Dashboard</h1>
    <a href="{{Cookie::get('role')}}/permissions">Get permissions</a>
@endsection