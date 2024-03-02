
@extends('admin.templates.main')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
@endsection
@section('content')
    <div class="container">
         <!-- Page Heading -->
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jenis Kuis</h1>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if (isset($data))
                            
                        @endif
                        <form method="POST" action="{{ isset($data) ? route('quiz-type.update', $data->id) :  route('quiz-type.store')}}" id="formDataQuizType" enctype="multipart/form-data">
                            @csrf
                            @if (isset($data))
                                {{ method_field('PUT') }}
                            @endif
                            <div class="mb-3">
                                <label for="title" class="form-label">Jenis Kuis<span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" id="name" title="name"
                                    placeholder="masukan judul jenis video" value="{{ $data->name ?? '' }}" required>
                            </div>
                    
                            <button class="btn btn-primary" id="submit_button">Simpan</button>
                            <a href="{{ route('quiz-type.index') }}" class="btn btn-outline-primary" id="back_button">Back</a>
                        </form>
                    </div>
    
                </div>
            </div>
    
        </section>

    </div>
@endsection

@section('scripts')

    <script>
        $('document').ready(function() {
            $('#formDataQuizType').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let method = $(this).attr('method');
                let action = $(this).attr('action');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Add or update data",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, add it!',
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $.ajax({
                                method: method,
                                url: action,
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(res) {
                                    resolve(res);
                                },
                                error: function(err) {

                                    $('#loading_icon').hide();
                                    $('#submit_icon').show();
                                    $('#submit_button').attr('disabled',false);

                                    var response = JSON.parse(err
                                        .responseText);

                                    var errorString = '';
                                    if (typeof response.validator ===
                                        'object') {
                                        $.each(response.validator, function(
                                            key, value) {
                                            errorString += value +
                                                "<br>";
                                        });
                                    } else {
                                        errorString = response.message;
                                    }

                                    Swal.fire(
                                        'Wrong', errorString, 'error'
                                    )
                                }
                            })
                        });
                    }
                }).then(function(data) {
                    data = data.value;
                    if (data.status) {
                        Swal.fire(data.message, '', 'success').then(function() {
                            window.location = "{{ route('quiz-type.index') }}";
                        });
                    }
                });

            });
        });
    </script>
@endsection