@if(!empty($criteriaDetails))
    <div class="mb-3">
        <h6 class="font-weight-bold">Informasi Kriteria:</h6>
        <ul class="mb-0">
            @foreach($criteriaDetails as $criteria)
                <li>
                    {{ $criteria['name'] }} 
                    (Kategori: {{ ucfirst($criteria['category']) }}, 
                    Bobot: {{ number_format($criteria['weight'], 2) }})
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead class="thead-light">
            <tr>
                <th>Ranking</th>
                <th>Nama</th>
                <th>Rekening</th>
                <th>Pendapatan</th>
                <th>Jaminan</th>
                <th>Jumlah Pinjaman</th>
                <th>Nilai WP</th>
                <th>Normalized</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluations->sortByDesc('normalized_wp')->values() as $rank => $eval)
                @php
                    $loan = $eval->loan;
                    $user = $loan->user;
                    $profile = $user->profile;
                @endphp
                <tr>
                    <td>{{ $rank + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $profile?->nomor_rekening ?? '-' }}</td>
                    <td>{{ number_format($loan->pendapatan) }}</td>
                    <td>{{ number_format($loan->jaminan) }}</td>
                    <td>{{ number_format($loan->jumlah_pinjaman) }}</td>
                    <td>{{ number_format($eval->nilai_wp, 6) }}</td>
                    <td>{{ $eval->normalized_wp ? number_format($eval->normalized_wp, 6) : '-' }}</td>
                    <td>
                        @switch($loan->status)
                            @case('approved')
                                <span class="badge badge-success">Disetujui</span>
                                @break
                            @case('rejected')
                                <span class="badge badge-danger">Ditolak</span>
                                @break
                            @case('canceled')
                                <span class="badge badge-warning">Dibatalkan</span>
                                @break
                            @default
                                <span class="badge badge-secondary">Menunggu</span>
                        @endswitch
                    </td>
                    <td>
                        @if($loan->status === 'pending')
                            <form method="POST" action="{{ route('loans.approve', $loan) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" @if(!$isNormalized) disabled @endif>
                                    Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('loans.reject', $loan) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-danger" @if(!$isNormalized) disabled @endif>
                                    Tolak
                                </button>
                            </form>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
