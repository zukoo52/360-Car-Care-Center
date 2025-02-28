@extends('layouts.admin')

@section('content')
<permission-component :user_id="{{Auth::user()->id}}" />
@endsection