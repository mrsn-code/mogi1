@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
<div>
    <form class="page__wrapper" action="{{ route('purchase.checkout', $item->id) }}" method="POST">
        @csrf
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
                    <select name="payment_method" id="payment-select">
                        <option value="" selected disabled>選択してください</option>
                        <option value="konbini">コンビニ払い</option>
                        <option value="card">カード支払い</option>
                    </select>
                </div>
                @error('payment_method')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
            </div>
            <hr class="line">
            <div class="shipment__detail">
                <div class="shipment__nav">
                    <div class="shipment__title">配送先</div>
                    <a class="shipment__change" href="{{route('purchase.address.edit', $item)}}">変更する</a>
                </div>
                <div class="shipment__desctiption">
                    @if($shippingAddress['zipcode'] || $shippingAddress['address'])
                        <div>〒{{ $shippingAddress['zipcode'] }}</div>
                        <div>{{ $shippingAddress['address'] }}</div>
                        @if($shippingAddress['building'])
                            <div>{{ $shippingAddress['building'] }}</div>
                        @endif
                    @else
                        <div>〒 {{$user->zipcode}}</div>
                        <div>{{$user->address}} {{$user->building}}</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="check__panel">
            <table class="check__table">
                <tr>
                    <th class="table__head">商品代金</th>
                    <td class="table__data">¥ {{$item->price}}</td>
                </tr>
                <tr>
                    <th class="table__head">支払い方法</th>
                    <td class="table__data">
                        <div id="selected-payment">未選択</div>
                    </td>
                </tr>
            </table>
            <div class="purchase__button">
                <button class="purchase__button--submit" type="submit">購入する</button>
            </div>
            @error('payment_method')
            <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/payment.js')}}"></script>
@endsection