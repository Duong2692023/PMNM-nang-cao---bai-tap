  @push('styles')
  <style>
  /* ---------- HEADER ---------- */
    .header {
      background-color: var(--mau-chinh);
      color: #fff;
      padding: 16px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      /* flex-shrink: 0 -> không cho header bị bóp lại */
      flex-shrink: 0;
    }
    .logo { font-size: 20px; font-weight: 700; }
    .logo span { color: var(--mau-nhan); }

    .menu-ngang { list-style: none; display: flex; gap: 6px; }
    .menu-ngang a {
      color: #fff; text-decoration: none;
      padding: 8px 14px; border-radius: 4px;
      transition: background-color 0.2s;
    }
    .menu-ngang a:hover,
    .menu-ngang a.active { background-color: rgba(255,255,255,0.15); }
</style>
  @endpush
  <header class="header">
    <div class="logo">HUCE<span>.Web</span></div>
    <nav>
      <ul class="menu-ngang">
        <li><a href="#" class="active">Trang chủ</a></li>
        <li><a href="#">Bài giảng</a></li>
        <li><a href="#">Bài tập</a></li>
        <li><a href="#">Liên hệ</a></li>
      </ul>
    </nav>
  </header>
