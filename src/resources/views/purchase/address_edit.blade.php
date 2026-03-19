@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/address_edit.css')}}">
@endsection

@section('content')
<div class="address-edit__wrapper">
    <div class="address-edit__heading">
        <h1>住所の変更</h1>
    </div>

    <form action="{{ route('purchase.address.update', $item) }}" method="POST">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="zipcode" id="zipcode" value="{{old('zipcode', $shippingAddress['zipcode'])}}">
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
                    <input type="text" name="address" id="address" value="{{old('address', $shippingAddress['address'])}}">
                </div>
            </div>
            @error('address')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" id="building" value="{{old('building', $shippingAddress['building'])}}">
                </div>
            </div>
            @error('building')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection