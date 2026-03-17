@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/create.css')}}">
@endsection

@section('content')
<div class="page__wrapper">
    <div class="page__heading">
        <h1>商品の出品</h1>
    </div>
    <form class="form" action="{{route('items.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="img__wrapper">
            <div class="img__title">商品画像</div>
            <input class="img__select" type="file" name="item_img" id="item_img">画像を選択する</input>
        </div>
        <div class="item__detail">
            <h2>商品の詳細</h2>
            <hr>
            <div class="category__wrapper">
                <div class="category__title">カテゴリー</div>
                <div class="category__group">
                    @foreach($categories as $category)
                    <div class="category__tab">
                        <input
                            class="category__checkbox"
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            id="category_{{ $category->id }}"
                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                        >
                        <label class="category__label" for="category_{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="condition__wrapper">
                <div class="condition__title">商品の状態</div>
                <select class="condition__selector" name="condition" id="condition">
                    <option value="" selected disabled>選択してください</option>
                    @foreach(\App\Models\Item::CONDITIONS as $value => $label)
                    <option value="{{ $value }}" {{ old('condition') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                
            </div>
        </div>
        <div class="item__description">
            <h2>商品名と説明</h2>
            <div class="descrption--group">
                <label class="description--title" for="item_name">商品名</label>
                <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}">
            </div>
            <div class="descrption--group">
                <label class="description--title" for="brand_name">ブランド名</label>
                <input type="text" name="brand_name" id="brand_name" value="{{ old('brand_name') }}">
            </div>
            <div class="descrption--group">
                <label class="description--title" for="description">商品の説明</label>
                <input type="text" name="description" id="description" value="{{ old('description') }}">
            </div>
            <div class="descrption--group">
                <label class="description--title" for="price">販売価格</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}">
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>

@if ($errors->any())
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
@endif

@endsection