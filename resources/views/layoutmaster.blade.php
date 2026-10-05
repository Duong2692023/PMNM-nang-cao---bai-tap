<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    /* ==========================================================
       PHIÊN BẢN FLEXBOX — cùng một layout, kỹ thuật khác
       Ý tưởng: lồng 2 tầng flex
         Tầng 1 (dọc):  header  →  .than-trang  →  footer
         Tầng 2 (ngang): sidebar  →  main
       ========================================================== */
    :root {
      --mau-chinh:    #3d2b56;   /* tím than */
      --mau-phu:      #55407a;
      --mau-nhan:     #f2b544;   /* vàng nghệ */
      --mau-nen:      #f7f5fa;
      --mau-vien:     #e3dfea;
      --rong-sidebar: 240px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      font-size: 15px;
      line-height: 1.6;
      color: #2b2b2b;
      background-color: var(--mau-nen);

      /* Tầng 1: xếp các khối theo CHIỀU DỌC */
      display: flex;
      flex-direction: column;
      min-height: 100vh;   /* để footer luôn chạm đáy */
    }

    /* ---------- THÂN TRANG ---------- */
    .than-trang {
      /* Tầng 2: xếp sidebar và main theo CHIỀU NGANG */
      display: flex;
      /* flex: 1 -> khối này "ăn" hết chỗ trống còn lại theo chiều dọc,
         nhờ đó footer bị đẩy xuống đáy màn hình */
      flex: 1;
    }

    /* ---------- MAIN ---------- */
    .main {
      /* flex: 1 -> chiếm toàn bộ chiều ngang còn lại
         min-width: 0 -> chống lỗi nội dung dài làm tràn khung
         (lỗi kinh điển khi học Flexbox, nhớ nhắc sinh viên) */
      flex: 1;
      min-width: 0;
      padding: 20px;
    }
    .main h1 { font-size: 26px; color: var(--mau-chinh); margin-bottom: 6px; }
    .main .mo-ta { color: #7a7290; margin-bottom: 20px; }

    .noi-dung {
      background-color: #fff;
      border: 1px solid var(--mau-vien);
      border-radius: 6px;
      padding: 22px;
    }
    .noi-dung h2 {
      font-size: 18px; color: var(--mau-chinh); margin-bottom: 10px;
      padding-bottom: 8px;
      border-bottom: 2px solid var(--mau-nhan);
      display: inline-block;
    }
    .noi-dung p { margin-bottom: 12px; }
    .noi-dung ul { margin: 0 0 12px 22px; }
    .noi-dung code {
      background-color: #efebf5; padding: 2px 6px; border-radius: 3px;
      font-family: Consolas, monospace; font-size: 13px; color: #8a4b1f;
    }

    /* ---------- RESPONSIVE ----------
       Với Flexbox phải đổi flex-direction của .than-trang từ row sang
       column, đồng thời chỉnh lại flex-basis của sidebar. So với Grid
       (chỉ cần vẽ lại grid-template-areas) thì phức tạp hơn một chút. */
    @media (max-width: 768px) {
      .header { flex-direction: column; align-items: flex-start; }

      .than-trang { flex-direction: column; }

      .sidebar {
        flex: 0 0 auto;      /* bỏ chiều rộng cố định */
        width: 100%;
        padding: 12px 0;
      }
      .menu-doc { display: flex; flex-wrap: wrap; margin-bottom: 0; }
      .menu-doc a {
        border-left: none;
        border-bottom: 3px solid transparent;
        padding: 8px 14px;
      }
      .menu-doc a:hover { padding-left: 14px; }
    }
  </style>

</head>

<body>
    @include('partial.header')

    <div class="than-trang">
    @include('partial.sidebar')
    <main class="main">
      <h1 class="tieu-de">
        @yield('title')
      </h1>
      <p class="mo-ta">@yield('description')</p>

      <article class="noi-dung">
            @include('partial.alert')
            @yield('content')
      </article>
    </main>
  </div>
      @include('partial.footer')
  @stack('styles')
  {{-- JS của Bootstrap: cần cho nút đóng alert, dropdown, modal... --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
