@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="status__wrapper">
    <a class="status__button {{ $tab !== 'mylist' ? 'active' : '' }}" href="/">おすすめ</a>
    <a class="status__button {{ $tab === 'mylist' ? 'active' : '' }}" href="/?tab=mylist">マイリスト</a>
</div>
<hr class="hr-line">
<div class="items__wrapper">
    @forelse($items as $item)
    <a class="items__group" href="{{route('item.show', $item)}}">
        <div class="items__img">
            <img src="{{asset($item->item_img)}}">
        </div>
        <div class="items__caption">{{$item->item_name}}</div>
    </a>
    @empty
    <p class="empty-message">
        {{ request('tab') === 'mylist'
            ? 'マイリストになにも追加されていません'
            : '商品がありません' }}
    </p>
    @endforelse
</div>
@endsection