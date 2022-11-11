@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Tabel KirimWA') }}</div>

                <div class="card-body">
                    {{-- make div inline --}}
                    <div class="d-flex flex-row">

                        {{-- make form upload data --}}

                        <div class="p-2">
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Add Data
                            </button>
                        </div>
                        <div class="p-2">
                            <form action="{{ route('importData') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex flex-row">
                                    <div>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                    <div class="pl-2">
                                        <button class="btn btn-success" type="submit">Import Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('addData') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Gelar</label>
                                        <select class="form-select" aria-label="Default select example" name="gelar">
                                            <option selected value="">Pilih Gelar</option>
                                            <option value="Bpk">Bapak</option>
                                            <option value="Ibu">Ibu</option>
                                            <option value="Mas">Mas</option>
                                            <option value="Mba">Mba</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label
                                        ">Nama</label>
                                        <input type="text" class="form-control" name="nama" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Nomor</label>
                                        <input type="text" class="form-control" name="no_wa" id="exampleInputPassword1">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>

                            </div>

                        </div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor</th>
                                <th>Gelar</th>
                                <th>Nama</th>
                                <th>Terkirim</th>
                                <th>Updated At</th>
                                <th>Action</th>
                                <th>Delete</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kirimwa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->no_wa }}</td>
                                <td>{{ $item->gelar }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->terkirim }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td class="text-center">
                                    <form action="{{ route('sendMessage') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-sm btn-primary">Send</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('deleteData', $item->id) }}" class="btn btn-sm btn-danger">Delete</a>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$item->id *100}}">
                                        Edit
                                    </button>
                                    <div class="modal fade" id="exampleModal-{{$item->id *100}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('updateData') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">Gelar</label>
                                                        <select class="form-select" aria-label="Default select example" name="gelar">
                                                            <option value="" @if ($item->gelar == '') selected @endif>Pilih Gelar</option>
                                                            <option value="Bpk" @if ($item->gelar == 'Bpk') selected @endif>Bapak</option>
                                                            <option value="Ibu" @if ($item->gelar == 'Ibu') selected @endif>Ibu</option>
                                                            <option value="Mas" @if ($item->gelar == 'Mas') selected @endif>Mas</option>
                                                            <option value="Mba" @if ($item->gelar == 'Mba') selected @endif>Mba</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label
                                                        ">Nama</label>
                                                        <input type="text" class="form-control" value="{{ $item->nama }}" name="nama" id="exampleInputEmail1" aria-describedby="emailHelp">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">Nomor</label>
                                                        <input type="text" class="form-control" value="{{$item->no_wa}}" name="no_wa" id="exampleInputPassword1">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </form>

                                            </div>

                                        </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- cdn Jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- cdn Datatable --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
{{-- cdn Datatable --}}

<script>
    $(document).ready(function () {
        $('#data').DataTable(
            {
                "order": [[ 4, "asc" ]]
            }
        );

    });
</script>
@endsection
