
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="dashboard-asesor">
                <img src="{{ asset('assets') }}/img/polindra.png" alt="logo" width="25"
                    style="margin-right: 6px; margin-bottom: 4px;">
                SIAPTEKNIK
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="dashboard-asesor">
                <img src="{{ asset('assets') }}/img/polindra.png" alt="logo" width="30">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Ajuan Program Studi</li>
            <li class="dropdown {{ Request::segment('1') == 'asesor-ajuanprodi' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-database" aria-hidden="true"></i>
                    <span>Dokumen Ajuan </span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $prodi = App\Models\ProgramStudi::with('jenjang')
                            ->whereHas('user_asesor', function ($query) {
                                $query->where('user_id', Auth::user()->id);
                            })
                            ->get();
                    @endphp
                    @foreach ($prodi as $p)
                        <li>
                            <a class="nav-link mt-1 mb-3" value="{{ $p->id }}"
                                href="{{ route('asesor-ajuanprodi.prodi', $p->id) }}">
                                {{ $p->jenjang->jenjang }} {{ $p->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="menu-header">Penilaian Akreditasi</li>
            <li class="dropdown {{ Request::segment('1') == 'nilai-asesmen-kecukupan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-folder-open" aria-hidden="true"></i>
                    <span>Asesmen Kecukupan</span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $prodi = App\Models\ProgramStudi::with('jenjang')
                            ->whereHas('user_asesor', function ($query) {
                                $query->where('user_id', Auth::user()->id);
                            })
                            ->get();
                    @endphp
                    @foreach ($prodi as $p)
                        <li><a class="nav-link mt-1 mb-3" value="{{ $p->id }}"
                                href="{{ route('asesor.penilaian.asesmen-kecukupan.elemen', $p->id) }}">
                                {{ $p->jenjang->jenjang }} {{ $p->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="dropdown {{ Request::segment('1') == 'nilai-asesmenlapangan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-folder" aria-hidden="true"></i>
                    <span>Asesmen Lapangan</span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $prodi = App\Models\ProgramStudi::with('jenjang')
                            ->whereHas('user_asesor', function ($query) {
                                $query->where('user_id', Auth::user()->id);
                            })
                            ->get();
                    @endphp
                    @foreach ($prodi as $p)
                        <li><a class="nav-link mt-1 mb-3" value="{{ $p->id }}"
                                href="{{ route('nilai-asesmenlapangan.elemen', $p->id) }}">
                                {{ $p->jenjang->jenjang }} {{ $p->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="dropdown {{ Request::segment(1) == 'rekomendasi' ? 'active' : '' }}">
                <a href="{{ url('rekomendasi') }}">
                    <i class="fas fa-file" aria-hidden="true"></i>
                    <span>Rekomendasi Pembinaan</span>
                </a>
            </li>
            <li class="menu-header">Rekapitulasi Penilaian</li>
            <li class="dropdown  {{ Request::segment('1') == 'rekap-nilaiAk' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    <span>Rekap Desk Evaluasi</span>
                </a>
                <ul class="dropdown-menu mb-4">
                    @php
                        $prodi = App\Models\ProgramStudi::with('jenjang')
                            ->whereHas('user_asesor', function ($query) {
                                $query->where('user_id', Auth::user()->id);
                            })
                            ->get();
                    @endphp
                    @foreach ($prodi as $p)
                        <li><a class="nav-link mt-1 mb-3" value="{{ $p->id }}"
                                href="{{ route('rekap-nilaiAk.prodi', $p->id) }}">
                                {{ $p->jenjang->jenjang }} {{ $p->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="mt-2 dropdown {{ Request::segment('1') == 'rekap-nilaiAl' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-lock" aria-hidden="true">
                    </i><span>Rekap Asesmen Lapangan</span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $prodi = App\Models\ProgramStudi::with('jenjang')
                            ->whereHas('user_asesor', function ($query) {
                                $query->where('user_id', Auth::user()->id);
                            })
                            ->get();
                    @endphp
                    @foreach ($prodi as $p)
                        <li><a class="nav-link mt-3 mb-3" value="{{ $p->id }}"
                                href="{{ route('rekap-nilaiAl.prodi', $p->id) }}">
                                {{ $p->jenjang->jenjang }} {{ $p->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    
    
    
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    
    
    
        </div>
    </aside>
</div>
