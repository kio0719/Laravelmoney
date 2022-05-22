<div class="container mb-5">
  <ul class="nav nav-tabs nav-fill">
  <li class="nav-item"><a class="nav-link @if(Request::routeIs('user.profile')) active @endif" href="{{route('user.profile')}}">ホーム</a></li>
    <li class="nav-item"><a class="nav-link @if(Request::routeIs('log.getregistar')) active @endif" href="{{route('log.getregistar')}}">家計簿</a></li>
    <li class="nav-item"><a class="nav-link @if(Request::routeIs('asset.getlist')) active @endif" href="{{route('asset.getlist')}}">資産</a></li>
    <li class="nav-item"><a class="nav-link @if(Request::routeIs('account.getlist')) active @endif" href="{{route('account.getlist')}}">勘定科目</a></li>
    <li class="nav-item dropdown"><!-- ここからドロップダウン -->
      <a class="nav-link dropdown-toggle @if(Request::routeIs('log.getaslist') || Request::routeIs('log.getatlist') || Request::routeIs('log.getalllist') ) active @endif" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">履歴</a>
      <div class="dropdown-menu">
        <a class="dropdown-item @if(Request::routeIs('log.getaslist')) active @endif" href="{{route('log.getaslist')}}">資産残高履歴</a>
        <a class="dropdown-item @if(Request::routeIs('log.getatlist')) active @endif" href="{{route('log.getatlist')}}">入出金履歴</a>
        <a class="dropdown-item @if(Request::routeIs('log.getalllist')) active @endif" href="{{route('log.getalllist')}}">全体履歴</a>
      </div>
    </li>
</div>