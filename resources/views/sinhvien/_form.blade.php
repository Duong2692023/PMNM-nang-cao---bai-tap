<div class="row">
    <div class="col-md-6 mb-3">
        <label for="ma_sv" class="form-label">Mã số sinh viên <span class="text-danger">*</span></label>
        <input type="text" id="ma_sv" name="ma_sv"
               class="form-control @error('ma_sv') is-invalid @enderror"
               value="{{ old('ma_sv', $sinhVien->ma_sv) }}" maxlength="20" required>
        @error('ma_sv')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="ho_ten" class="form-label">Họ tên <span class="text-danger">*</span></label>
        <input type="text" id="ho_ten" name="ho_ten"
               class="form-control @error('ho_ten') is-invalid @enderror"
               value="{{ old('ho_ten', $sinhVien->ho_ten) }}" maxlength="100" required>
        @error('ho_ten')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="lop_hoc_id" class="form-label">Lớp quản lý <span class="text-danger">*</span></label>
        <select id="lop_hoc_id" name="lop_hoc_id"
                class="form-select @error('lop_hoc_id') is-invalid @enderror" required>
            <option value="">Chọn lớp</option>
            @foreach ($lopHocs as $lopHoc)
                <option value="{{ $lopHoc->id }}"
                        @selected((string) old('lop_hoc_id', $sinhVien->lop_hoc_id) === (string) $lopHoc->id)>
                    {{ $lopHoc->ten_lop }} — {{ $lopHoc->khoa_hoc }}
                </option>
            @endforeach
        </select>
        @error('lop_hoc_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" id="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $sinhVien->email) }}" maxlength="150" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3 form-check">
    <input type="hidden" name="trang_thai" value="0">
    <input type="checkbox" id="trang_thai" name="trang_thai" value="1"
           class="form-check-input @error('trang_thai') is-invalid @enderror"
           @checked(old('trang_thai', $sinhVien->trang_thai))>
    <label for="trang_thai" class="form-check-label">Đang hoạt động</label>
    @error('trang_thai')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
