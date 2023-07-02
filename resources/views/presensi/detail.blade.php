@if ($riwayat->isEmpty())
<div class="alert alert-warning">
    <p>Tidak ada data yang ditampilkan</p>
</div>
@else

@php
    $nomer = 1;
@endphp
<ul class="listview image-listview">
    <li>
<div class="item">
    <div class="in">
        <div class="col-12 d-flex">
            <div class="col-1">
                <strong>
                    No
                </strong>
            </div>
            <div class="col-5 d-flex justify-content-center">
                <strong>
                    Tanggal
                </strong>
            </div>
            <div class="col-3  d-flex justify-content-center">
                <span class=""> <strong>Masuk</strong></span>
            </div>
            <div class="col-3 d-flex justify-content-center">
                <span class=""> <strong>Pulang</strong></span>

            </div>
        </div>
    </div>
</div>
</li>
</ul>
    
@foreach ($riwayat as $d)
<ul class="listview image-listview">
    <li>
        <div class="item">
            <div class="in">
                <div class="col-12 d-flex">
                    <div class="col-1">
                        <div class="badge badge-primary">
                            {{ $nomer++ }}
                        </div>
                    </div>
                    <div class="col-5 d-flex justify-content-center">
                        <b>
                            {{ $d->tgl_presensi }}
                        </b>
                    </div>
                    <div class="col-3  d-flex justify-content-center">
                        <span class="badge p-2 mx-2  bg-{{ $d->jam_in <= '07:00' ? 'success' : 'danger'  }}">{{ $d->jam_in}}</span>
                    </div>
                    <div class="col-3 d-flex justify-content-center">
                        <span class="badge p-2 mx-2 bg-primary">{{ $d->jam_out}}</span>

                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>
    
@endforeach
@endif
