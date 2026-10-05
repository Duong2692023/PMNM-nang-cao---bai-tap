{{--
    Form dùng chung cho create và edit (@include('lophoc._form'))
    - old('field', $lopHoc->field): ưu tiên dữ liệu vừa nhập khi validate lỗi,
      nếu không có thì lấy giá trị từ model (trang sửa) hoặc rỗng (trang thêm)
    - @error('field'): hiển thị lỗi ngay dưới từng ô nhập
--}}
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="ten_lop" class="form-label">Tên lớp <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('ten_lop') is-invalid @enderror"
               id="ten_lop" name="ten_lop" value="{{ old('ten_lop', $lopHoc->ten_lop) }}">
        @error('ten_lop')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="khoa_hoc" class="form-label">Khóa học <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('khoa_hoc') is-invalid @enderror"
               id="khoa_hoc" name="khoa_hoc" value="{{ old('khoa_hoc', $lopHoc->khoa_hoc) }}">
        @error('khoa_hoc')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="si_so" class="form-label">Sĩ số <span class="text-danger">*</span></label>
        <input type="number" min="0" class="form-control @error('si_so') is-invalid @enderror"
               id="si_so" name="si_so" value="{{ old('si_so', $lopHoc->si_so) }}">
        @error('si_so')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="giao_vien_chu_nhiem" class="form-label">Giáo viên chủ nhiệm <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('giao_vien_chu_nhiem') is-invalid @enderror"
           id="giao_vien_chu_nhiem" name="giao_vien_chu_nhiem"
           value="{{ old('giao_vien_chu_nhiem', $lopHoc->giao_vien_chu_nhiem) }}">
    @error('giao_vien_chu_nhiem')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3 form-check">
    {{-- Checkbox không được tích sẽ KHÔNG gửi gì lên server.
         Input hidden phía trước đảm bảo luôn có trang_thai = 0 khi bỏ tích. --}}
    <input type="hidden" name="trang_thai" value="0">
    <input type="checkbox" class="form-check-input" id="trang_thai" name="trang_thai" value="1"
           @checked(old('trang_thai', $lopHoc->trang_thai))>
    <label class="form-check-label" for="trang_thai">Đang hoạt động</label>
</div>

<div class="mb-3">
    <label for="ghi_chu" class="form-label">Ghi chú</label>
    <textarea class="form-control @error('ghi_chu') is-invalid @enderror" id="ghi_chu" name="ghi_chu" rows="3">{{ old('ghi_chu', $lopHoc->ghi_chu) }}</textarea>
    @error('ghi_chu')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
