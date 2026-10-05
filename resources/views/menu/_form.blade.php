{{-- Form dùng chung cho create và edit (@include('menu._form')) --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="ten" class="form-label">Tên menu <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('ten') is-invalid @enderror"
               id="ten" name="ten" value="{{ old('ten', $menu->ten) }}">
        @error('ten')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="parent_id" class="form-label">Menu cha</label>
        <select id="parent_id" name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
            <option value="">— Không có (đây là menu nhóm) —</option>
            @foreach ($nhoms as $nhom)
                <option value="{{ $nhom->id }}" @selected(old('parent_id', $menu->parent_id) == $nhom->id)>{{ $nhom->ten }}</option>
            @endforeach
        </select>
        @error('parent_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-3">
        <label for="duong_dan" class="form-label">Đường dẫn</label>
        <input type="text" class="form-control @error('duong_dan') is-invalid @enderror"
               id="duong_dan" name="duong_dan" value="{{ old('duong_dan', $menu->duong_dan) }}"
               placeholder="/lophoc hoặc https://...">
        @error('duong_dan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Menu nhóm chỉ hiển thị tiêu đề nên có thể bỏ trống.</div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="thu_tu" class="form-label">Thứ tự <span class="text-danger">*</span></label>
        <input type="number" min="0" class="form-control @error('thu_tu') is-invalid @enderror"
               id="thu_tu" name="thu_tu" value="{{ old('thu_tu', $menu->thu_tu) }}">
        @error('thu_tu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3 form-check">
    <input type="hidden" name="trang_thai" value="0">
    <input type="checkbox" class="form-check-input" id="trang_thai" name="trang_thai" value="1"
           @checked(old('trang_thai', $menu->trang_thai))>
    <label class="form-check-label" for="trang_thai">Hiển thị trên sidebar</label>
</div>
