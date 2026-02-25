@extends('layouts.app')
@section('css')
@endsection

@section('content')
@foreach($items as $item)
<img src="{{asset($item->item_img)}}">
@endforeach
@endsection