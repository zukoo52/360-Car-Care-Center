@extends('layouts.admin')

@section('content')
<profile-view-component :user="{{Auth::user()}}" />
@endsection
