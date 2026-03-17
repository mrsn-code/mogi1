<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
  <link rel="stylesheet" href="{{asset('css/common.css')}}">
  @yield('css')
</head>
<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/"><img src="{{asset('images/COACHTECHヘッダーロゴ.png')}}"></a>
      <div class="header__search">
        <form>
          <input type="text" placeholder="なにをお探しですか？">
        </form>
      </div>
      <nav>
        <ul class="header-nav">
          @guest
          <li class="header-nav__item">
            <a class="header-nav__link" href="/login">ログイン</a>
          </li>
          @endguest
          @auth
          <li>
            <form action="/logout" method="post">
              @csrf
              <button class="header__logout--button" type="submit">ログアウト</button>
            </form>
          </li>
          @endauth
          <li class="header-nav__item">
            <a class="header-nav__link" href="/mypage">マイページ</a>
          </li>
          <li class="header-nav__item">
            <a class="header-nav__link" href="{{route('items.create')}}">出品</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <main>
    @yield('content')
  </main>
</body>
</html>