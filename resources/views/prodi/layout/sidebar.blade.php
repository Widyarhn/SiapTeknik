<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="dashboard-prodi">
            <img src="{{ asset('assets') }}/img/polindra.png" alt="logo" width="25"
                style="margin-right: 6px; margin-bottom: 4px;">
            SIAPTEKNIK
        </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="dashboard-prodi">
            <img src="{{ asset('assets') }}/img/polindra.png" alt="logo" width="30">
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Ajuan Dokumen Program Studi</li>
        @php
            $prodi = App\Models\ProgramStudi::with('jenjang')
                ->whereHas('user_prodi', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();
            $activeProdiId = Request::segment(3); // Assuming the program studi ID is the second segment in the URL
        @endphp
        @foreach ($prodi as $p)
            {{-- <li class="dropdown {{ Request::segment(1) == 'ajuan-prodi' && $activeProdiId == $p->id ? 'active' : '' }}"> --}}
                <li class="dropdown {{ Request::segment(1) == 'ajuan-prodi' ? 'active' : '' }}">
                <a value="{{ $p->id }}" href="{{ route('ajuan-prodi.prodi', $p->id) }}">
                    <i class="fas fa-file" aria-hidden="true"></i>
                    <span>{{ $p->jenjang->jenjang }} {{ $p->nama }}</span>
                </a>
            </li>
        @endforeach
        <li class="menu-header">History Akreditasi</li>
        @php
            $prodi = App\Models\ProgramStudi::with('jenjang')
                ->whereHas('user_prodi', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();// Assuming the program studi ID is the second segment in the URL
        @endphp
        @foreach ($prodi as $p)
            <li class="dropdown {{ Request::segment(1) == 'history' ? 'active' : '' }}">
                <a value="{{ $p->id }}" href="{{ route('history', $p->id) }}">
                    <i class="fas fa-database" aria-hidden="true"></i>
                    <span>{{ $p->jenjang->jenjang }} {{ $p->nama }}</span>
                </a>
            </li>
        @endforeach
        <li class="menu-header">Data Dukung</li>
        <li class="dropdown {{ Request::segment('1') == 'data-dukung' ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-columns" aria-hidden="true"></i>
                <span>Dokumen Data Dukung</span>
            </a>
            <ul class="dropdown-menu">
                @php
                    $prodi = App\Models\ProgramStudi::with('jenjang')
                        ->whereHas('user_prodi', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        })
                        ->get();
                @endphp
                @foreach ($prodi as $p)
                    <li>
                        <a class="nav-link mt-1 mb-3" value="{{ $p->id }}"
                            href="{{ route('prodi.data-dukung.elemen', $p->id) }}">
                            {{ $p->jenjang->jenjang }} {{ $p->nama }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="menu-header">Instrumen akreditasi</li>
        @php
            $prodi = App\Models\Jenjang::whereHas('user_prodi', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
        @endphp
        @foreach ($prodi as $p)
            <li class="dropdown {{ Request::segment('1') == 'instrumen-prodi' ? 'active' : '' }}">
                <a href="{{ route('prodi.instrumen', $p->id) }}" value="{{ $p->id }}">
                    <i class="fas fa-archive" aria-hidden="true"></i>
                    <span>Instrumen akreditasi Jenjang {{ $p->jenjang }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</aside>
