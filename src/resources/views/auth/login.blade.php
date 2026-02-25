@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection

@section('content')
<div class="admin-form__content">
    <div class="admin-form__heading">
        <h2>ログイン</h2>
    </div>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="email" value="{{old('email')}}">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">パスワード</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password" value="{{old('password')}}">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログインする</button>
        </div>
    </form>
    <div class="link">
        <a class="link__button" href="/register">会員登録はこちら</a>
    </div>
</div>
@if ($errors->any())
    <div style="color:red;">
        {{ $errors->first() }}
    </div>
@endif

@endsection