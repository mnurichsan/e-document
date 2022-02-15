
@extends('layouts.app')
@section('content')

            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Kategori Dokumen</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible  show mb-1" style="margin-bottom: 0" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Daftar Kategori </h4>
                                    <button type="button" class="btn btn-primary waves-effect waves-light " data-toggle="modal" data-target="#add">
                                        <i class="feather icon-plus"></i> Tambah Kategori
                                    </button>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <p class="card-text"></p>
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Kategori</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                @foreach ($kategori as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->name}}</td>
                                                        <td> 
                                                            <button type="button" class="btn btn-icon btn-info  wav  es-effect waves-light" data-toggle="modal" data-target="#edit" 
                                                            onclick="get('{{ $item->id }}')">
                                                            <i class="feather icon-edit"></i> Edit
                                                            </button>
                                                            <form action="/kategori/{{ $item->id }}" method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button class="btn btn-icon btn-danger mr-1  waves-effect waves-light" onclick="return confirm('yakin ?')" > <i class="feather icon-x"></i> Hapus</button>
                                                            </form>    
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <form class="form-horizontal"  action="/kategori/" method="post"  >
                            @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel1">Tambah Kategori</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-label-group position-relative ">
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="fname-floating-icon" placeholder="Nama Kategori" >
                                                <label for="first-name-floating-icon">Nama Kategori</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-outline-warning ">Reset</button>

                            </div>
                         </form>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <form class="form-horizontal"  method="post" id="formedit" enctype="multipart/form-data" >
                            @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel1">Edit Kategori </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group" style="display: none;">
                                        <input type="text" class="form-control" name="id" id="idEdit" placeholder="">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-label-group position-relative ">
                                            <input type="text" name="name" id="nameEdit" class="form-control @error('name') is-invalid @enderror" name="fname-floating-icon" placeholder="Nama Kategori" >
                                            <div class="form-control-position">
                                                <i class="feather icon-user"></i>
                                            </div>
                                            <label for="first-name-floating-icon">Nama Kategori</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="edit()" class="btn btn-primary" >Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



    <script>
        function edit() {
            let form = $("#formedit");
            var formData = new FormData(form[0]);
            // console.log(formData);
            $.ajax({
                url: "/kategori/update",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    alertSuksesEdit();
                    setInterval(
                        function() {
                            location.reload();
                        }, 2000);
                },
                error: function() {
                    alert('Wajib Diisi');
                }
            })
        }

        function alertSuksesEdit() {
            Swal.fire(
            'Success!',
            'Tracker Changed!',
            'success'
            )
        }
        function get(id) {
            fetch('/kategori/get/' + id)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    $("#idEdit").val(id);
                    $("#nameEdit").val(data.name);
                });
             }
            </script>

@endsection