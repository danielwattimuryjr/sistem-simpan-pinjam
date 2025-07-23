@php
    $accordionId = 'pinjaman-accordion-' . ($accordionIdPrefix ?? 'default');
@endphp

<div class="accordion" id="{{ $accordionId }}">
   @foreach($groupedEvaluations as $groupKey => $evaluations)
        @php
            [$hash, $batchNumber] = explode('|', $groupKey);
            $accordionIndex = $loop->index;
            $accordionItemId = "collapse-{$accordionId}-{$accordionIndex}";
            $isNormalized = $evaluations->sum('normalized_wp') > 0;
            $details = $evaluations->first()->details ?? [];
        @endphp

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" id="heading-{{ $accordionItemId }}">
                <div class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse"
                            data-target="#{{ $accordionItemId }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                            aria-controls="{{ $accordionItemId }}">
                       Batch #{{ $batchNumber }}
                    </button>

                    @if($isNormalized)
                        <span class="badge badge-success">Sudah Dinormalisasi</span>
                    @endif
                </div>

                @if (!$isNormalized)
                    <form method="POST" action="{{ route('pinjaman.normalize') }}">
                        @csrf
                        <input type="hidden" name="criteria_hash" value="{{ $hash }}">
                        <input type="hidden" name="batch_number" value="{{ $batchNumber }}">
                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="fas fa-balance-scale"></i> Normalisasi WP
                        </button>
                    </form>
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
