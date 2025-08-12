<html>

<!-- Modal Tambah Rekening -->
<div class="modal fade" id="modalTambahRekening" tabindex="-1" role="dialog" aria-labelledby="modalTambahRekeningLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('daftar.rekening') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Tambah Nomor Rekening</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="bank">Pilih Bank <small>(Hubungi BAKU Jika Pilihan Bank Tidak
                                Ada)</small></label>
                        <select name="nm_bank" class="select2 form-control" required>
                            <option value="">--Pilih Bank--</option>
                            @foreach ($bankpemohon as $bank)
                                <option value="{{ $bank->id_bank }}">{{ $bank->nama_bank }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input type="number" name="no_rekening" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Atas Nama</label>
                        <input type="text" name="atas_nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Informasi Tambahan</label>
                        <textarea name="info" class="form-control" placeholder="Informasi Cabang Atau Kosongkan Jika Tidak Diperlukan"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

</html>
