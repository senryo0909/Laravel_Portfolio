<header>
<nav class="navbar navbar-expand navbar-dark bg-success">

  <a class="navbar-brand" href="{{ route('welcome') }}"><i class="fa fa-3x fa-home"></i>Home画面へ戻る</a>
  <!-- Dropdown宣言 -->
  <ul class="navbar-nav ml-auto">
    
    <!-- Dropdown中身の定義 -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-3x fa-user-circle"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
        <button class="dropdown-item" type="button" 
                onclick="location.href='#'">
          マイページ<span class="text-danger">**現在作成中</span>
        </button>
        <div class="dropdown-divider"></div>
        <button form="logout-button" class="dropdown-item" type="submit">
          ログアウト
        </button>
      </div>
    </li>
    <form id="logout-button" method="POST" action="{{ route('admin.logout') }}"> 
    @csrf
    </form>
  <!-- End of Dropdown -->
  </ul>
</nav>
</header>
