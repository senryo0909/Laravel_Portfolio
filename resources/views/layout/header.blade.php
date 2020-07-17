<header class="fixed-top bg-primary" style="height: 100px">
        <div class="d-flex justify-content-between" style="height: 100px">
          <div style="font-size: 2rem;" class="ml-5 align-self-center">業務管理システム</div>
            <div class="mr-5 align-self-center">
            {{-- usersテーブル、individualテーブルが完了後に移行したい処理 --}}
            {{-- <a href="{{!! url('/individual', [$user->id] !!}}" class="mr-3 text-danger">
            {{-- <a href="{{!! url('/logout', [$user->id] !!}}" class="mr-3 text-danger"> --}}
            <meta name="csrf-token" content="{{ csrf_token() }}">
              <a href="#" style="font-size: 2rem;" class="mr-3 text-danger">{{ Auth::user()->name }}</a><br>
              <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit" value="{{ Auth::user()->id }}">logout</button>
                <!-- <a href="{{ route('user.logout') }}" style="font-size: 1.5rem;" class="text-dark">logout</a>  -->
              </form>
          </div>
        </div>
</header>