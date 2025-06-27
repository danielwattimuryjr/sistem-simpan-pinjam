@php
    $accordionId = 'pinjaman-accordion-' . ($accordionIdPrefix ?? 'default');
@endphp

<div class="accordion" id="{{ $accordionId }}">
   @foreach($groupedEvaluations as $groupKey => $evaluations)
        @php
            [$hash, $evaluatedAt] = explode('|', $groupKey);
            $accordionIndex = $loop->index;
            $accordionItemId = "collapse-{$accordionId}-{$accordionIndex}";
            $isNormalized = $evaluations->sum('normalized_wp') > 0;
            $latestEvaluatedAt = \App\Models\LoanEvaluation::max('evaluated_at');
            $details = $evaluations->first()->details ?? [];
        @endphp

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" id="heading-{{ $accordionItemId }}">
                <div class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse"
                            data-target="#{{ $accordionItemId }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                            aria-controls="{{ $accordionItemId }}">
                       Evaluasi #{{ $loop->iteration }} — {{ \Carbon\Carbon::parse($evaluatedAt)->format('d M Y H:i') }}
                    </button>

                    @if($evaluations->first()->evaluated_at == $latestEvaluatedAt)
                        <span class="badge badge-primary">Batch Terbaru</span>
                    @endif

                    @if($isNormalized)
                        <span class="badge badge-success">Sudah Dinormalisasi</span>
                    @endif
                </div>

                @if (!$isNormalized)
                    <form method="POST" action="{{ route('pinjaman.normalize') }}">
                        @csrf
                        <input type="hidden" name="criteria_hash" value="{{ $hash }}">
                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="fas fa-balance-scale"></i> Normalisasi WP
                        </button>
                    </form>
                @else
                    <div class="btn-group">
                        <a href="{{ route('pinjaman.export', ['hash' => $hash, 'type' => 'xlsx']) }}" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                        <a href="{{ route('pinjaman.export', ['hash' => $hash, 'type' => 'csv']) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-file-csv"></i> CSV
                        </a>
                        <a href="{{ route('pinjaman.export', ['hash' => $hash, 'type' => 'pdf']) }}" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                @endif
            </div>

            <div id="{{ $accordionItemId }}"
                 class="collapse @if($loop->first) show @endif"
                 data-parent="#{{ $accordionId }}">
                <div class="card-body">
                    @include('pinjaman.partials.evaluation-table', [
                        'evaluations' => $evaluations,
                        'isNormalized' => $isNormalized,
                    ])
                </div>
            </div>
        </div>
    @endforeach
</div>
