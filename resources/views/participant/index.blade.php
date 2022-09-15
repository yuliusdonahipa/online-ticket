@extends('layouts.app2')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Data Peserta</h3>

                        <div class="pull-right mb-2">
                            <a class="btn btn-success" onClick="addFunc()" href="javascript:void(0)"> Add</a>
                        </div>

                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Tiket</th>
                                    <th>Event Name</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Is Payment</th>
                                    <th>Is Present</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div class="modal fade" id="modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title"></h4>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0)" id="form" name="form" class="form-horizontal"
                            method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Uuid</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="uuid" name="uuid"
                                        placeholder="Uuid" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Address" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="checkbox" class="control-label" id="is_payment" name="is_payment">
                                    <label class="form-check-label" for="is_payment">Ispayment</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="checkbox" class="control-label" id="is_present" name="is_present">
                                        <label class="form-check-label" for="is_present">Ispresent</label>
                                    </div>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                                </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('participant.index') }}",
                        data: function(e) {
                            e.search = $('input[type="search"]').val()
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'uuid',
                            name: 'uuid'
                        },
                        {
                            data: 'event.name',
                            name: 'Event Name'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'is_payment',
                            name: 'is_payment'
                        },
                        {
                            data: 'is_present',
                            name: 'is_present'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });
            });

            function addFunc() {
                $('#form').trigger("reset");
                $('#title').html("Add Data");
                $('#modal').modal('show');
                $('#id').val('');
            }

            function editFunc(id) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('participant.edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#title').html("Edit Data");
                        $('#modal').modal('show');
                        $('#id').val(res.id);
                        $('#uuid').val(res.uuid);
                        $('#name').val(res.name);
                        $('#email').val(res.email);
                        $('#address').val(res.address);
                        $("#is_payment").prop("checked", res.is_payment);
                        $("#is_present").prop("checked", res.is_present);
                    }
                });
            }


            function delFunc(id) {
                swal({
                        title: "Confirm Delete!",
                        text: "Data tidak dapat dikembalikan",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "/participant/" + id,
                                type: 'DELETE',
                                success: function() {
                                    swal("Berhasil dihapus", {
                                        icon: "success",
                                    });
                                }

                            });

                        }
                    });
            }


            $('#form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var is_payment = formData.get('is_payment') === 'on' ? 1 : 0,
                    is_present = formData.get('is_present') === 'on' ? 1 : 0;

                formData.set('is_payment', is_payment);
                formData.set('is_present', is_present);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('participant.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#modal").modal('hide');
                        var table = $('.data-table').dataTable();
                        table.fnDraw(false);
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);

                        swal("Berhasil disimpan", {
                            icon: "success",
                        });
                    },
                    error: function(data) {
                        swal("Terjadi kesalahan", {
                            icon: "error",
                        });
                    }
                });
            });
        </script>
    @endsection
