@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
<div class="page__wrapper">
    <div class="config__panel">
        <div class="item__detail">
            <div class="item__img">
                <img src="{{asset('storage/' . $item->item_img)}}">
            </div>
            <div class="item__description">
                <div class="item__name">{{$item->item_name}}</div>
                <div class="item__price">¥ {{$item->price}}</div>
            </div>
        </div>
        <hr class="line">
        <div class="method__detail">
            <div class="method__title">支払い方法</div>
            <div class="method__select">
                <select>
                    <option value="" selected disabled>選択してください</option>
                    <option value="">コンビニ払い</option>
                    <option value="">カード支払い</option>
                </select>
            </div>
        </div>
        <hr class="line">
        <div class="shipment__detail">
            <div class="shipment__nav">
                <div class="shipment__title">配送先</div>
                <a class="shipment__change" href="">変更する</a>
            </div>
            <div class="shipment__desctiption">
                <div>〒 {{$user->zipcode}}</div>
                <div>{{$user->address}} {{$item->building}}</div>
            </div>
        </div>
    </div>
    <div class="check__panel">
        <table class="check__table">
            <tr class="table__row">
                <th class="table__head">商品代金</th>
                <td>¥ {{$item->price}}</td>
            </tr>
            <tr>
                <th class="table__head">支払い方法</th>
                <td></td>
            </tr>
        </table>
        <div class="purchase__button">
            <button class="purchase__button--submit">購入する</button>
        </div>
    </div>
</div>
@endsection