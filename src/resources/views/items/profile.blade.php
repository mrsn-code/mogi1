@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('content')
<div class="profile-form__content">
    <div class="profile-form__heading">
        <h2>プロフィール設定</h2>
    </div>

    @if(session('success'))
        <div class="alert__success">{{session('success')}}</div>
    @endif

    <form class="form" action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="img__group">
            <img class="user__img" id="preview" src="{{ $user->icon_img ? asset('storage/' . $user->icon_img) : '' }}">
            <label class="file__button">
                <input class="img__select" type="file" name="icon_img" id="icon_img">画像を選択する</input>
            </label>
            @error('icon_img')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">ユーザー名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{old('name', $user->name)}}">
                </div>
            </div>
            @error('name')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="zipcode" value="{{old('zipcode', $user->zipcode)}}">
                </div>
            </div>
            @error('zipcode')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" value="{{old('address', $user->address)}}">
                </div>
            </div>
            @error('address')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" value="{{old('building', $user->building)}}">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/change_img.js')}}"></script>
@endsection