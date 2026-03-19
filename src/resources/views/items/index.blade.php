@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="status__wrapper">
    <a class="status__button {{ ($tab ?? 'index') === 'index' ? 'active' : '' }}" href="/?tab=index&keyword={{ $keyword ?? '' }}">
        おすすめ
    </a>

    <a class="status__button {{ ($tab ?? '') === 'mylist' ? 'active' : '' }}" href="/?tab=mylist&keyword={{ $keyword ?? '' }}">
        マイリスト
    </a>
</div>
<!-- <div class="status__wrapper">
    <a class="status__button {{ $tab !== 'mylist' ? 'active' : '' }}" href="/?tab=index&keyword={{request('keyword')}}">おすすめ</a>
    <a class="status__button {{ $tab === 'mylist' ? 'active' : '' }}" href="/?tab=mylist&keyword={{request('keyword')}}">マイリスト</a>
</div> -->
<hr class="hr-line">
<div class="items__wrapper">
    @forelse($items as $item)
    <a class="items__group" href="{{route('items.show', $item)}}">
        <img class="items__img" src="{{asset('storage/' . $item->item_img)}}">
        @auth
            @if ($item->buyer_id === Auth::id())
                <div class="sold-label">SOLD</div>
            @endif
        @endauth
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