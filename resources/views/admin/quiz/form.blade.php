
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
            <h1 class="h3 mb-0 text-gray-800"> Kuis </h1>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if (isset($data))
                            
                        @endif
                        <form method="POST" action="{{ isset($data) ? route('quiz.update', $data->id) :  route('quiz.store')}}" id="formDataQuiz" enctype="multipart/form-data">
                            @csrf
                            @if (isset($data))
                                {{ method_field('PUT') }}
                            @endif
                            <div class="mb-3">
                                <label for="question" class="form-label">Pernyataan <span class="text-danger">*</span>
                                </label>
                                <textarea name="question" class="form-control" rows="10" cols="50" required>  {!! $data->question ?? '' !!} </textarea>
                            </div>
                            <div class="mb-3">
                                <label for="quiz_type_id" class="form-label">Jenis Kuis <span class="text-danger">*</span></label>
                                <select name="quiz_type_id" id="quiz_type_id" class="form-control" required>
                                    <option value=""> Pilih </option>
                                    @foreach ($quizType as $item)
                                        <option value="{{ $item['id'] }}" {{ isset($data) ? ($data->quiz_type_id == $item['id'] ? 'selected' : '') : '' }}>{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="answer" class="form-label">Jawaban <span class="text-danger">*</span></label>
                                <select name="answer" id="answer" class="form-control" required>
                                    <option value="">Pilih </option>
                                    <option value="1" {{ isset($data) ? ($data->answer == 1 ? 'selected' : '') : '' }}>Benar</option>
                                    <option value="0" {{ isset($data) ? ($data->answer == 0 ? 'selected' : '') : '' }}>Salah</option>
                                </select>
                            </div>
                    
                            <button class="btn btn-primary" id="submit_button">Simpan</button>
                            <a href="{{ route('quiz.index') }}" class="btn btn-outline-primary" id="back_button">Back</a>
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
            $('#formDataQuiz').submit(function(e) {
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
                            window.location = "{{ route('quiz.index') }}";
                        });
                    }
                });

            });
        });
    </script>
@endsection