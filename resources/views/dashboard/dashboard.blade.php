@extends('layouts.presensi')
@section('content')
<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            @if (!empty(Auth::guard('karyawan')->user()->foto))
                @php
                    $path = asset('profil/karyawan/'.Auth::guard('karyawan')->user()->foto);
               @endphp
            <img src="{{url($path) }}" alt="avatar" class="imaged w64 rounded">
            @else
            <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
            @endif

        </div>
        <div id="user-info">
            <h2 id="user-name">{{ $profil->nama_lengkap }}</h2>
            <span id="user-role">{{ $namaJabatan }}</span>
        </div>
    </div>
</div>

<div class="section" id="menu-section">
    <div class="card">
        <div class="card-body text-center">
            <div class="list-menu">
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="green" style="font-size: 40px;">
                            <ion-icon name="person-sharp"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Profil</span>
                    </div>
                </div>
                {{-- <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="danger" style="font-size: 40px;">
                            <ion-icon name="calendar-number"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Cuti</span>
                    </div>
                </div> --}}
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="/presensi/riwayat" class="warning" style="font-size: 40px;">
                            <ion-icon name="document-text"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Histori</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="orange" style="font-size: 40px;">
                            <ion-icon name="location"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        Lokasi
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section mt-2" id="presence-section">
    <div class="todaypresence">
        <div class="row">
            <div class="col-6">
                <div class="card gradasigreen">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="body-outline"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Masuk</h4>
                                @if ($infoMasuk == null)
                                
                                <span>Belum absen</span>
                                @else
                                <span>{{ $infoMasuk->jam_in}}</span>
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card gradasired">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="walk-outline"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Pulang</h4>
                                @if ($infoKeluar == null)
                                
                                <span>Belum absen</span>
                                @else
                                <span>{{ $infoKeluar->jam_out}}</span>
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="rekappresensi">
        <h4>Rekap bulan {{ $namaBulan }}</h4>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 15px 20px; line-height:0.3rem">
                        <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px;font-size: 0.8rem; z-index: 20">{{ $rekapBulan->jmlhadir }}</span>
                        <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem;white-space: nowrap; font-weight:500;">Hadir</span>

                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 15px 20px; line-height:0.3rem">
                        <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px;font-size: 0.8rem; z-index: 20">{{ $rekapBulan->jmlTerlambat }}</span>
                        <ion-icon name="alert-circle-outline" style="font-size: 1.6rem;" class="text-warning mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem;white-space: nowrap; font-weight:500;">Telat</span>

                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 15px 20px; line-height:0.3rem">
                        <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px;font-size: 0.8rem; z-index: 20">10</span>
                        <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem;white-space: nowrap; font-weight:500;">Hadir</span>

                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 15px 20px; line-height:0.3rem">
                        <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px;font-size: 0.8rem; z-index: 20">10</span>
                        <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem;white-space: nowrap; font-weight:500;">Hadir</span>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="presencetab mt-2">
        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        Bulan Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        Leaderboard
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($historybulanini as $rekap)
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="image-outline" role="img" class="md hydrated"
                                    aria-label="image outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>{{ date("d-m-Y",strtotime($rekap->tgl_presensi)) }}</div>
                                <span class="badge {{ $rekap->jam_in > '07:00' ? 'bg-warning': 'bg-success'}}">{{ $rekap->jam_in }}</span>
                                <span class="badge badge-primary">{{ $rekap->jam_out != null ? $rekap->jam_out : "Belum Absen" }}</span>
                            </div>
                        </div>
                    </li>
                        
                    @endforeach
              
                </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($leaderboard as $lb) 
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    <b>{{ $lb->nama_lengkap }}</b><br>
                                    <small>{{ $lb->nama_jabatan }}</small>
                                </div>
                                
                                <span class="badge {{ $lb->jam_in > '07:00' ? 'bg-warning' : 'bg-success' }}">{{ $lb->jam_in }}</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection