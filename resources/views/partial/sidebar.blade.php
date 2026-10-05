@push('styles')
<style>
/* ---------- SIDEBAR ---------- */
    .sidebar {
      background-color: var(--mau-phu);
      color: #fff;
      padding: 20px 0;
      /* Cú pháp: flex: grow shrink basis
         0 0 240px = không giãn, không co, rộng đúng 240px */
      flex: 0 0 var(--rong-sidebar);
    }
    .sidebar h3 {
      font-size: 12px; text-transform: uppercase; letter-spacing: 1px;
      opacity: 0.7; padding: 0 20px; margin-bottom: 10px;
    }
    .menu-doc { list-style: none; margin-bottom: 24px; }
    .menu-doc a {
      display: block; color: #fff; text-decoration: none;
      padding: 10px 20px;
      border-left: 3px solid transparent;
      transition: all 0.2s;
    }
    .menu-doc a:hover {
      background-color: rgba(0,0,0,0.15);
      border-left-color: var(--mau-nhan);
      padding-left: 26px;
    }
    .menu-doc a.active {
      background-color: rgba(0,0,0,0.25);
      border-left-color: var(--mau-nhan);
      font-weight: 600;
    }
</style>
@endpush
  <aside class="sidebar">
      {{-- $menus được truyền vào bởi View Composer trong AppServiceProvider --}}
      @foreach ($menus as $nhom)
        <h3>{{ $nhom->ten }}</h3>
        <ul class="menu-doc">
          @foreach ($nhom->children as $menu)
            <li><a href="{{ $menu->href }}" @class(['active' => $menu->dangChon()])>{{ $menu->ten }}</a></li>
          @endforeach
        </ul>
      @endforeach
    </aside>
