@foreach($semuaData as $i => $data)
    @include('guru.raport.pdf', $data)
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach