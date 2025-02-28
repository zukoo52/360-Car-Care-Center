@extends('layouts.admin')

@section('content')
<role-based-permission :role="{{$role}}" />
@endsection