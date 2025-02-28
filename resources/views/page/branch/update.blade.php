@extends('layouts.admin')

@section('content')
    <update-branch-component :branch="{{$branch}}"/>
@endsection
