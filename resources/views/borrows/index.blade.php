@extends('layouts.main') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session("status") }}
            </div>
            @endif
            @can('admin')
            <a href="{{ url('/admin/borrows/create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data Peminjam an</a>
            @endcan
            @can('operator')
            <a href="{{ url('/operator/borrows/create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data Peminjam
                an</a>
            @endcan
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Name</th>
                        <th>Nama Peminjam</th>
                        <th>Kode Verifikasi Peminjaman</th>
                        <th>Borrow Code</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Jumlah Di Pinjam</th>
                        <th>Borrow Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrows as $borrow)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $borrow->item_name }}</td>
                        <td>{{ $borrow->full_name }}</td>
                        <td>{{ $borrow->verification_code_for_borrow_request }}</td>
                        <td>{{ $borrow->borrow_code }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td>{{ $borrow->return_date }}</td>
                        <td>{{ $borrow->borrow_quantity }}</td>
                        <td>
                            @if($borrow->borrow_status == 'completed')
                            <span class="badge bg-success">Selesai</span>
                            @elseif($borrow->borrow_status == 'pending')
                            <span class="badge bg-warning">Belum Di Verifikasi</span>
                            @else
                            <span class="badge bg-primary">Di Pinjam</span>
                            @endif
                        </td>
                        <td>
                            @can('admin')
                            <a href="{{ url('/admin/borrows', $borrow->id) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i> Show</a>
                            @endcan
                            @can('operator')
                            <a href="{{ url('/operator/borrows', $borrow->id) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i> Show</a>
                            @endcan

                            @if ($borrow->borrow_status == 'completed')
                            <button class="btn btn-success" disabled>
                                <i class="fas fa-check-circle"></i> Selesai
                            </button>
                            @elseif ($borrow->borrow_status == 'pending')
                            @can('admin')
                            <a href="{{ url('admin/borrows/'.$borrow->borrow_code.'/submit-borrow-request') }}"
                                class="btn btn-warning">
                                <i class="fas fa-check"></i> Verifikasi
                            </a>
                            @endcan
                            @can('operator')
                            <a href="{{ url('operator/borrows/'.$borrow->borrow_code.'/submit-borrow-request') }}"
                                class="btn btn-warning">
                                <i class="fas fa-check"></i> Verifikasi
                            </a>
                            @endcan
                            @elseif ($borrow->borrow_status == 'borrowed')
                            @can('admin')
                            <form action="{{ url('/admin/borrows/'.$borrow->id.'/return') }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-undo"></i> Return
                                </button>
                            </form>
                            @endcan
                            @can('operator')
                            <form action="{{ url('/operator/borrows/'.$borrow->id.'/return') }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-undo"></i> Return
                                </button>
                            </form>
                            @endcan
                            @can('admin')
                            <a href="{{ url('/admin/borrows/'.$borrow->id.'/edit') }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i> Edit</a>
                            @endcan
                            @can('operator')
                            <a href="{{ url('/operator/borrows/'.$borrow->id.'/edit') }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i> Edit</a>
                            @endcan
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
