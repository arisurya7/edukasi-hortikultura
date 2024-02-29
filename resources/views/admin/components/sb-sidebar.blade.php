  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            
        </div>
        <div class="sidebar-brand-text mx-3">Edukasi Hortikultura</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    {{-- @if (Auth::user()->hasRole(['admin'])) --}}
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    {{-- @endif --}}


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTours"
            aria-expanded="true" aria-controls="collapseTours">
            <i class="fas fa-fw fa-cog"></i>
            <span>Tanaman</span>
        </a>
        <div id="collapseTours" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Packages:</h6>
                <a class="collapse-item" href="#">Data Artikel</a>
                <a class="collapse-item" href="#">Data Kategori</a>
            </div>
        </div>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('plant.index') }}">
            <i class="fas fa-tree"></i>
            <span>Tanaman</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('plant-disease.index') }}">
            <i class="fas fa-disease"></i>
            <span>Penyakit Tanaman</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('plant-pest.index') }}">
            <i class="fas fa-pastafarianism"></i>
            <span>Hama Tanaman</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('plant-tips.index') }}">
            <i class="far fa-lightbulb"></i>
            <span>Tips Tanaman</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('video.index') }}">
            <i class="fas fa-video"></i>
            <span>Video Tanaman</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTours"
            aria-expanded="true" aria-controls="collapseTours">
            <i class="fas fa-fw fa-cog"></i>
            <span>Kuis</span>
        </a>
        <div id="collapseTours" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Packages:</h6>
                <a class="collapse-item" href="{{ route('quiz-type.index') }}">Data Jenis Kuis</a>
                <a class="collapse-item" href="{{ route('quiz.index') }}"  >Data Kuis</a>
            </div>
        </div>
    </li>

   
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
