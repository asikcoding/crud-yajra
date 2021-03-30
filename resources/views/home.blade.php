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


@endpush
@endsection
