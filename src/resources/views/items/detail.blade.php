@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection

@section('content')
<div class="page__wrapper">
    <div class="image__wrapper">
        <img src="{{asset('storage/' . $item->item_img)}}">
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
                <div class="icon__field--count">{{$item->comments_count}}</div>
            </div>
        </div>
        <div class="purchase__link">
            <a href="{{route('purchase.show', $item)}}" >購入手続きへ</a>
        </div>
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
        <div class="comment__num"><h2>コメント({{$item->comments_count}})</h2></div>
        
        @foreach($item->comments as $comment)
        <div class="comment__group">
            <div class="comment__user">
                <div class="comment__user--icon"><img src=""></div>
                <div class="comment__user--name">{{$comment->user->name}}</div>
            </div>
            <div class="comment__content">{!! nl2br(e($comment->body)) !!}</div>
        </div>
        @endforeach

        <form class="comment__form" action="{{ route('items.comments.store', $item) }}" method="post">
            @csrf
            <div class="comment__title">商品へのコメント</div>
            <textarea class="comment__area" name="body" rows="8"></textarea>
            @error('body')
                <div style="color: red;">{{ $message }}</div>
            @enderror
            <button class="comment__button" type="submit">コメントを送信する</button>
        </form>
    </div>
</div>
@endsection