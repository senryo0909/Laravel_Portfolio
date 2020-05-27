<header class="fixed-top bg-primary" style="height: 100px">
        <div class="d-flex justify-content-between" style="height: 100px">
          <div class="ml-5 align-self-center">業務管理システム</div>
          <div class="mr-5 align-self-center">
            {{-- usersテーブル、individualテーブルが完了後に移行したい処理 --}}
            {{-- <a href="{{!! url('/individual', [$user->id] !!}}" class="mr-3 text-danger">
            <a href="{{!! url('/logout', [$user->id] !!}}" class="mr-3 text-danger"> --}}

                <a href="#" class="mr-3 text-danger">{{ Auth::user()->name }}さん</a>
                <a href="#" class="text-danger">logout</a>
          </div>
        </div>
</header>