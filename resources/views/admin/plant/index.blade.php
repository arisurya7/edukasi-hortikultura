@extends('admin.templates.main')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid">
         <!-- Page Heading -->
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Tanaman</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-8">
                <div class="card shadow mb-1">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tanaman</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('plant.create') }}"
                                    class="btn btn-primary mt-2 mb-3">Tambah Tanaman</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover yajra-datatable display" style="width:100%"
                                    id="table-tanaman">
                                    <thead>
                                        <tr>
                                            <th class="index">#</th>
                                            <th>Nama Tanaman</th>
                                            <th width="20%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        let data_post = {}
        var table_post = $('#table-tanaman').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('getDataPlant') }}',

            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-align-center text-center',
                    orderlable: false,
                    searchable: false,
                }
            ]
        });

        function deletePlant(id_data) {
            Swal.fire({
                title: 'Anda yakin hapus tanaman?',
                text: "Data tanaman tidak dapat dilihat lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: '/admin/plant/' + id_data,
                        data: {
                            id: id_data,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                successModal('Your post has been deleted.')
                                 $('#table-tanaman').DataTable().ajax.reload(null, false);
                            } else {
                                errorModal();
                            }
                        },
                        error: function(xhr, textStatus, error) {
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    });
                }
            });
        }

        function errorModal() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
        }

        function successModal(msg) {
            Swal.fire(
                'Success!',
                msg,
                'success');
        }
    </script>
@endsection
