@extends('admin.dashboard')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Transaksi Pengguna</h5>
    </div>
    <div class="card-body">
        <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Invoice ID</th>
                    <th>Status</th>
                    <th>Proof</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->user->name }}</td>
                    <td>INV-{{ $transaction->id }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>
                        @if($transaction->payment_proof && file_exists(public_path('storage/payment_proofs/' . basename($transaction->payment_proof))))
                            <a href="{{ asset('storage/payment_proofs/' . basename($transaction->payment_proof)) }}" target="_blank">Lihat Bukti</a>
                        @else
                            <span class="text-muted">Bukti tidak tersedia</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.updateTransactionStatus', $transaction->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $transaction->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $transaction->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection






