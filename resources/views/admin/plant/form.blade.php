
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
            <h1 class="h3 mb-0 text-gray-800">Tanaman</h1>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if (isset($data))
                            
                        @endif
                        <form method="POST" action="{{ isset($data) ? route('plant.update', $data->id) :  route('plant.store')}}" id="formDataPlant" enctype="multipart/form-data">
                            @csrf
                            @if (isset($data))
                                {{ method_field('PUT') }}
                            @endif
                            <div class="mb-3">
                                <label for="title" class="form-label">Nama <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" id="name" title="name"
                                    placeholder="masukan nama tanaman" value="{{ $data->name ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Bellow Temperature <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="bellow_temperature" class="form-control" id="bellow_temperature" title="Batas Suhu Bawah"
                                    placeholder="masukan batas suhu bawah" value="{{ $data->bellow_temperature ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Top Temperature <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="top_temperature" class="form-control" id="top_temperature" title="Batas Suhu Atas"
                                    placeholder="masukan batas suhu atas" value="{{ $data->top_temperature ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="plant_type_id" class="form-label">Jenis Tanaman <span class="text-danger">*</span></label>
                                <select name="plant_type_id" id="plant_type_id" class="form-control" required>
                                    <option value="">Pilih </option>
                                    @foreach ($plantType as $item)
                                        <option value="{{ $item['id'] }}" {{ isset($data)? ($data->plant_type_id == $item['id'] ? 'selected' : '') : '' }}>{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="img" class="form-label">Foto <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="img" name="img" placeholder="pilih foto" max="2048" accept="image/*" value="{{$data->img ?? ''}}"  {{ isset($data) ? '' : 'required' }}>
                            </div>

                            <div class="mb-3">
                                <textarea name="desc" class="form-control" rows="20" cols="50">  {!! $data->desc ?? '' !!} </textarea>
                            </div>
                    
                            <button class="btn btn-primary" id="submit_button">Simpan</button>
                            <a href="{{ route('plant.index') }}" class="btn btn-outline-primary" id="back_button">Back</a>
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
            $('#formDataPlant').submit(function(e) {
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
                            window.location = "{{ route('plant.index') }}";
                        });
                    }
                });

            });
        });
    </script>
@endsection