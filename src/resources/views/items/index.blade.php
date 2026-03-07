@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="status__wrapper">
    <a class="status__recommend" href="">おすすめ</a>
    <a class="status__mylist">マイリスト</a>
</div>
<hr class="hr-line">
<div class="items__wrapper">
    @foreach($items as $item)
    <a class="items__group" href="{{route('item.show', $item)}}">
        <div class="items__img">
            <img src="{{asset($item->item_img)}}">
        </div>
        <div class="items__caption">{{$item->item_name}}</div>
    </a>
    @endforeach
</div>
@endsection