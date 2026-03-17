@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="user__info">
    @auth
    <div class="user__img">
        <img src="">
    </div>
    <div class="user__name">{{$user->name}}</div>
    @endauth
    <div class="profile__edit">
        <a href="/mypage/profile">プロフィールを編集</a>
    </div>
</div>
<div class="status__wrapper">
    <a class="status__button {{ $tab === 'sell' ? 'active' : '' }}" href="{{ route('mypage', ['tab' => 'sell']) }}">
        出品した商品
    </a>
    <a class="status__button {{ $tab === 'buy' ? 'active' : '' }}" href="{{ route('mypage', ['tab' => 'buy']) }}">
        購入した商品
    </a>
</div>
<hr class="hr-line">
<div class="items__wrapper">
    @forelse($items as $item)
    <a class="items__group" href="{{route('items.show', $item)}}">
        <div class="items__img">
            <img src="{{asset('storage/' . $item->item_img)}}">
        </div>
        <div class="items__caption">{{$item->item_name}}</div>
    </a>
    @empty
    <p class="empty-message">
        @if ($tab === 'sell')
            <p>出品した商品はありません。</p>
        @else
            <p>購入した商品はありません。</p>
        @endif
    </p>
    @endforelse
</div>
@endsection