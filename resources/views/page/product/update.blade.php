@extends('layouts.admin')

@section('content')
    <update-product-component :product="{{$product}}"/>
@endsection
