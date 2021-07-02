    <div class="row mt-3">
        <div class="col-sm-12 col-md-8">
            <!-- DETALLES -->
            @include('livewire.sales.partials.detail')
        </div>
        <div class="col-sm-12 col-md-4">
            <!-- TOTAL -->
            @include('livewire.sales.partials.total')
            <!-- DENOMINATIONS -->
            @include('livewire.sales.partials.coins')

        </div>
    </div>
<script src="{{ asset('js/keypress-2.1.5.min.js')}}"></script>
<script src="{{ asset('js/onscan.min.js')}}"></script>
@include('livewire.sales.scripts.shortcuts')
@include('livewire.sales.scripts.events')
@include('livewire.sales.scripts.general')
@include('livewire.sales.scripts.scan')
