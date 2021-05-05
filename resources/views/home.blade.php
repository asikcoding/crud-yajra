@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped" id="tabel1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telpon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="tambah" data-bs-target="#exampleModal">
        Tambah Data
      </button>
</div>
<!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Lengkap">
                <input type="hidden" id="id" name="id">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">No. Telpon</label>
                <input type="text" class="form-control" id="telp"  name="telp" placeholder="Masukkan Nomor Telpon">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Alamat</label>
               <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="5"></textarea>
              </div>

        </div>
        <div class="modal-footer">
          <button type="button" id="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="simpan" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function () {
        isi()
    })

    function isi() {
        $('#tabel1').DataTable({
            serverside : true,
            responseive : true,
            ajax : {
                url : "{{route('data')}}"
            },
            columns:[
                    {
                        "data" :null, "sortable": false,
                        render : function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {data: 'name', name: 'name'},
                    {data: 'telp', name: 'telp'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'aksi', name: 'aksi'}
                ]
        })
    }


</script>
<script>
    $('#simpan').on('click',function () {
        if ($(this).text() === 'Simpan Edit') {
            // console.log('Edit');
           edits()
        } else {
          tambah()
        }


    })
    
    $(document).on('click','.edit', function () {
        let id = $(this).attr('id')
        $('#tambah').click()
        $('#simpan').text('Simpan Edit')

        $.ajax({
            url : "{{route('edits')}}",
            type : 'post',
            data : {
                id : id,
                _token : "{{csrf_token()}}"
            },
            success: function (res) {
                $('#id').val(res.data.id)
                $('#nama').val(res.data.name)
                $('#telp').val(res.data.telp)
                $('#alamat').val(res.data.alamat)
            }
        })

    })
    /**
     * Tambah Data
     * @date 2021-05-05
     * @returns {any}
     */
    function tambah() {
        $.ajax({
                url : "{{route('data.store')}}",
                type : "post",
                data : {
                    nama : $('#nama').val(),
                    telp : $('#telp').val(),
                    alamat : $('#alamat').val(),
                    "_token" : "{{csrf_token()}}"
                },
                success : function (res) {
                    console.log(res);
                    alert(res.text)
                    $('#tutup').click()
                    $('#tabel1').DataTable().ajax.reload()
                    $('#nama').val(null)
                    $('#telp').val(null)
                    $('#alamat').val(null)
                },
                error : function (xhr) {
                    alert(xhr.responJson.text)
                }
            })
    }

    /**
     * 描述
     * @date 2021-05-05
     * @returns {any}
     */
    function edits() {
        $.ajax({
                url : "{{route('updates')}}",
                type : "post",
                data : {
                    id : $('#id').val(),
                    nama : $('#nama').val(),
                    telp : $('#telp').val(),
                    alamat : $('#alamat').val(),
                    "_token" : "{{csrf_token()}}"
                },
                success : function (res) {
                    console.log(res);
                    alert(res.text)
                    $('#tutup').click()
                    $('#tabel1').DataTable().ajax.reload()
                    $('#nama').val(null)
                    $('#telp').val(null)
                    $('#alamat').val(null)
                    $('#simpan').text('Simpan')
                },
                error : function (xhr) {
                    alert(xhr.responJson.text)
                }
            }) 
    }

    $(document).on('click','.hapus', function () {
        let id = $(this).attr('id')
        $.ajax({
            url : "{{route('hapus')}}",
            type : 'post',
            data: {
                id: id,
                "_token" : "{{csrf_token()}}"
            },
            success: function (params) {
                alert(params.text)
                $('#tabel1').DataTable().ajax.reload()
            }
        })
    })
</script>


@endpush
@endsection
