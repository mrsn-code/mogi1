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
        <div class="item__name"><h1>{{$item->item_name}}</h1></div>
        <div class="brand__name">{{$item->brand_name}}</div>
        <div class="item__price">
            <span class="item__price--part">¥</span> {{$item->price}} <span class="item__price--part">(税込)</span></div>
        <div class="icons">
            <div class="like__field">
                <form action="{{ route('items.like.toggle', $item) }}" method="post">
                    @csrf
                    <button class="icon__field--button" type="submit">
                        @auth
                            @if($item->isLikedBy(auth()->user()))
                                <img src="{{asset('images/heartlogo_pink.png')}}">
                            @else
                                <img src="{{asset('images/heartlogo_default.png')}}">
                            @endif
                        @else
                            <img src="{{asset('images/heartlogo_default.png')}}">
                        @endauth
                    </button>
                </form>
                <div class="icon__field--count">
                {{ $item->likedUsers()->count() }}
                </div>
            </div>
            <div class="balloon__field">
                <form action="">
                    @csrf
                    <button class="icon__field--button" type="submit">
                        @auth
                            <img src="{{asset('images/balloonlogo.png')}}">
                        @else
                            <img src="{{asset('images/balloonlogo.png')}}">
                        @endauth
                    </button>
                </form>
                <div class="icon__field--count">
                    temp
                <!-- {{ $item->likedUsers()->count() }} -->
                </div>
            </div>
        </div>
        <form class="purchase__form">
            <button>購入手続きへ</button>
        </form>
        <div class="item__description"><h2>商品説明</h2></div>
        <div class="item__description-detail">{{$item->description}}</div>
        <div class="item__information"><h2>商品の情報</h2></div>
        <div class="category__group">
            <div class="category__title">カテゴリー</div>
            <div class="category__details">
                @foreach ($item->categories as $category)
                    <div class="category__item">{{ $category->name }}</div>
                @endforeach
            </div>
        </div>
        <div class="condition__group">
            <div class="condition__title">商品の状態</div>
            <div class="condition__details">{{$item->condition_label}}</div>
        </div>
        <div class="comment__num"><h2>コメント()</h2></div>
        <div class="comment__group">
            <div class="comment__user"></div>
            <div class="comment__content"></div>
        </div>
        <form class="comment__form">
            <div class="comment__title">商品へのコメント</div>
            <textarea class="comment__area" rows="8"></textarea>
            <button class="comment__button">コメントを送信する</button>
        </form>
    </div>
</div>
@endsection