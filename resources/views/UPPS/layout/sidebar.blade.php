
<div class="main-sidebar sidebar-style-2">    
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="dashboard-UPPS">
                <img src="{{ asset('assets') }}/img/polindra.png" alt="logo" width="25"
                    style="margin-right: 6px; margin-bottom: 4px;">
                SIAPTEKNIK
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="dashboard-UPPS">
                <img src="{{ asset('assets') }}/img/polindra.png" alt="logo" width="30">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Data User</li>
            <li class="dropdown {{ Request::segment('1') == 'user-prodi' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-solid fa-user" aria-hidden="true"></i>
                    <span>User Program Studi</span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $jenjang = App\Models\Jenjang::get();
                    @endphp
                    @foreach ($jenjang as $p)
                        <li>
                            <a class="nav-link" value="{{ $p->id }}"
                                href="{{ route('UPPS.user-prodi.prodi', $p->id) }}">
                                Jenjang {{ $p->jenjang }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="dropdown {{ Request::segment('1') == 'user-asesor' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-solid fa-user" aria-hidden="true"></i>
                    <span>User Asesor</span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $jenjang = App\Models\Jenjang::get();
                    @endphp
                    @foreach ($jenjang as $p)
                        <li><a class="nav-link" value="{{ $p->id }}"
                                href="{{ route('UPPS.user-asesor.asesor', $p->id) }}">Jenjang {{ $p->jenjang }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="menu-header">Dokumen Penilaian</li>
            <li class="dropdown {{ Request::segment('1') == 'instrumen' ? 'active' : '' }}"">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-file" aria-hidden="true"></i>
                    <span>Instrumen Akreditasi</span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $jenjang = App\Models\Jenjang::get();
                    @endphp
                    @foreach ($jenjang as $p)
                        <li><a class="nav-link" value="{{ $p->id }}"
                                href="{{ route('UPPS.instrumen.jenjang', $p->id) }}">Jenjang {{ $p->jenjang }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="dropdown {{ Request::segment('1') == 'matriks-penilaian' ? 'active' : '' }}"">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book-open"
                        aria-hidden="true"></i><span>Matriks Penilaian</span></a>
                <ul class="dropdown-menu">
                    @php
                        $jenjang = App\Models\Jenjang::get();
                    @endphp
                    @foreach ($jenjang as $p)
                        <li><a class="nav-link" value="{{ $p->id }}"
                                href="{{ route('UPPS.matriks-penilaian.jenjang', $p->id) }}">Jenjang
                                {{ $p->jenjang }}</a></li>
                    @endforeach
                </ul>
            </li>
            {{-- <li class="menu-header">Dokumen Ajuan Program Studi</li>
            <li class="dropdown {{ Request::segment('1') == 'upps-dokumenajuan' ? 'active' : '' }}"">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"
                        aria-hidden="true"></i><span>Dokumen Ajuan</span></a>
                <ul class="dropdown-menu">
                    @php
                        $prodi = App\Models\ProgramStudi::with('jenjang')->get();
                    @endphp
                    @foreach ($prodi as $p)
                        <li>
                            <a class="nav-link mb-4" value="{{ $p->id }}"
                                href="{{ route('upps.dokumenajuan.prodi', $p->id) }}">
                                {{ $p->jenjang->jenjang }} {{ $p->nama }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li> --}}
            <li class="menu-header">Akreditasi</li>
            {{-- <li class="{{ Request::segment('1') == 'setting-tahun' ? 'active' : '' }}"">
                <a href="{{ route('setting-tahun.index') }}" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span>Setting Tahun Akreditasi</span>
                </a>
            </li> --}}
            <li class="{{ Request::segment('1') == 'akreditasi' ? 'active' : '' }}">
                <a href="{{ route('akreditasi.index') }}" class="nav-link">
                    <i class="fas fa-calendar-check"></i>
                    <span>Akreditasi Program Studi</span>
                </a>
            </li>
            
            <li class="dropdown {{ Request::segment('1') == 'upps-history-dokumenajuan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"
                        aria-hidden="true"></i><span>History Akreditasi</span></a>
                <ul class="dropdown-menu">
                    @php
                        $prodi = App\Models\ProgramStudi::with('jenjang')->get();
                    @endphp
                    @foreach ($prodi as $p)
                        <li>
                            <a class="nav-link mb-4" value="{{ $p->id }}"
                                href="{{ route('upps.dokumenajuan.prodi', $p->id) }}">
                                {{ $p->jenjang->jenjang }} {{ $p->nama }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            
            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-columns" aria-hidden="true"></i><span>Dokumen Data Dukung</span></a>
                <ul class="dropdown-menu">
                @php
                $prodi = App\Models\ProgramStudi::with('jenjang')->get();
                @endphp
                @foreach ($prodi as $p)
                <li><a class="nav-link" value="{{$p->id}}" href="{{route('Upps.data-dukung.elemen', $p->id)}}">{{$p->jenjang->jenjang}} {{$p->nama}}</a></li>
                @endforeach
                </ul>
            </li> --}}
            <li class="menu-header">Data Tambahan</li>
            <li class="{{ Request::segment('1') == 'kriteria' ? 'active' : '' }}"">
                <a href="{{ route('kriteria.index') }}" class="nav-link">
                    <i class="fas fa-newspaper"></i>
                    <span>Elemen Matriks Penilaian</span>
                </a>
                {{-- <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('jenis.index') }}">Jenis</a></li>
                    <li><a class="nav-link" href="{{ route('golongan.index') }}">Golongan</a></li>
                    <li><a class="nav-link" href="{{ route('kriteria.index') }}">Elemen</a></li>
                </ul> --}}
            </li>
        </ul>



        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">

        </div>
    </aside>
</div>

