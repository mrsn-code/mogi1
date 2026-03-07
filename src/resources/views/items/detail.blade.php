@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection

@section('content')
<div class="page__wrapper">
    <div class="image__wrapper">
        <img src="{{asset($item->item_img)}}">
    </div>
    <div class="caption__wrapper">
        <div class="item__name">{{$item->item_name}}</div>
        <div class="brand__name">{{$item->brand_name}}</div>
        <div class="item__price">{{$item->price}}</div>
        <div class="icons"></div>
        <form class="purchase__form">購入手続きへ</form>
        <div class="item__description">商品説明</div>
        <div class="item__description-detail"></div>
        <div class="item__information">商品の情報</div>
        <div class="category__group">
            <div class="category__title">カテゴリー</div>
            <div class="category__details"></div>
        </div>
        <div class="quality__group">
            <div class="quality__title">商品の状態</div>
            <div class="quality__details"></div>
        </div>
        <div class="comment__num">コメント()</div>
        <div class="comment__group">
            <div class="comment__user"></div>
            <div class="comment__content"></div>
        </div>
        <form class="comment__form">
            <div class="comment__title">商品へのコメント</div>
            <textarea class="comment__area"></textarea>
            <button class="comment__button">コメントを送信する</button>
        </form>
    </div>
</div>
@endsection