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
@endsection