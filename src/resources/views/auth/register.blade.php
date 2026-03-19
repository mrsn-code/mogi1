@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection

@section('content')
<div class="admin-form__content">
    <div class="admin-form__heading">
        <h2>会員登録</h2>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
            <span class="form__label--item">ユーザー名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{old('name')}}">
                </div>
            </div>
            <div class="form__error">
                @error('name')
                <p style="color: red;">
                    {{$message}}
                </p>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="email" value="{{old('email')}}">
                </div>
            </div>
            <div class="form__error">
                @error('email')
                <p style="color: red;">
                    {{$message}}
                </p>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">パスワード</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="password" value="{{old('password')}}">
                </div>
            </div>
            <div class="form__error">
                @error('password')
                <p style="color: red;">
                    {{$message}}
                </p>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">確認用パスワード</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="password_confirmation" value="{{old('password_confirmation')}}">
                </div>
            </div>
            <div class="form__error">
                @error('password_confirmation')
                <p style="color: red;">
                    {{$message}}
                </p>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">登録する</button>
        </div>
    </form>
    <div class="link">
        <a class="link__button" href="/login">ログインはこちら</a>
    </div>
</div>

@endsection