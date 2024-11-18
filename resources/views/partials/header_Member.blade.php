<!-- resources/views/partials/header.blade.php -->
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/quill/quill.bubble.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/remixicon/remixicon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/simple-datatables/style.css') }}">

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

{{-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

    <div class="container" style="color: #1E90FF; font-weight: bold; font-size: 1.2em; border: 3px solid #4169E1; border-radius: 10px; padding: 8px; background-color: #F0F8FF; box-shadow: 0 0 15px rgba(65, 105, 225, 0.6);">
        <!-- Add logo -->
        <a href="/" class="navbar-brand custom-font007A">
            <img src="{{ asset('images/hopital.jpg') }}" alt="Khmer Hospital Logo" class="logo" style="height: 90px; width: auto; border: 3px solid #ff69b4; border-radius: 10px; box-shadow: 0 0 10px rgba(255, 105, 180, 0.5);">



            <span style="color: #ff1493; font-weight: bold; font-size: 1.04em; border: 3px solid #ff69b4; border-radius: 15px; padding: 10px; background-color: #fff0f5; box-shadow: 0 0 10px rgba(255, 105, 180, 0.5);">
                &#x1F3E5; មន្ទីរពេទ្យបង្អែកខេត្តបាត់ដំបង &#x1F3E5;
                &#x1F3E5; Dashboard គ្រប់គ្រងដោយ {{ Auth::user()->role }} &#x1F3E5;
            </span>


        </a> <br> <br>



        <h1 class="nav-item dropdown">

        <a class="nav-item dropdown nav-link dropdown-toggle custom-font007A" href="#" id="navbarDropdown3" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                <img id="profileImage" src="{{ $user && $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/user.png') }}"  alt="Cute Profile Photo" class="logo" style="height: 90px; width: auto; border: 3px solid #ff69b4; border-radius: 50%; box-shadow: 0 0 10px rgba(255, 105, 180, 0.5); object-fit: cover;">

            <span> {{ Auth::user()->name }}</span>
        </a>


            <div class="dropdown-menu custom-font010" aria-labelledby="navbarDropdown3">
                <input type="text" class="form-control" id="dropdownSearch3" placeholder="Search...">
                <div id="dropdownItems3">
                    <a class="dropdown-item" href="{{ url('profile') }}"><span class="item-number">1.</span> {{ __('Profile') }}</a>
                    <a class="dropdown-item" href="{{ url('settings') }}"><span class="item-number">2.</span> Settings</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item"><span class="item-number">3.</span> {{ __('Log Out') }}</button>
                    </form>
                    <a class="dropdown-item" href="{{ url('profile') }}"><span class="item-number">1.</span> {{ __('Profile') }}</a>
                    <a class="dropdown-item" href="{{ url('settings') }}"><span class="item-number">2.</span> Settings</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item"><span class="item-number">3.</span> {{ __('Log Out') }}</button>
                    </form>
                    <a class="dropdown-item" href="{{ url('provinces') }}"><span class="item-number">4.</span> ខេត្តនីមួយៗ</a>
                    <a class="dropdown-item" href="{{ url('personal_info_emp') }}"><span class="item-number">5.</span> ជីវប្រវត្តិបុគ្គលិកឬមន្ត្រីទូទៅ</a>
                    <a class="dropdown-item" href="{{ url('identifications') }}"><span class="item-number">6.</span> អត្តសញ្ញាណក្របខណ្ឌ</a>
                    <a class="dropdown-item" href="{{ url('educations') }}"><span class="item-number">7.</span> កម្រិតវប្បធម៌</a>
                    <a class="dropdown-item" href="{{ url('positions') }}"><span class="item-number">8.</span> តួនាទីឬមុខតំណែង</a>
                    <a class="dropdown-item" href="{{ url('departments') }}"><span class="item-number">9.</span> ផ្នែក/ឯកទេស</a>
                    <a class="dropdown-item" href="{{ url('buildings') }}"><span class="item-number">10.</span> អាគារសុខាភិបាល</a>
                    <a class="dropdown-item" href="{{ url('category_employees') }}"><span class="item-number">11.</span> ប្រភេទបុគ្គលិកឬមន្ត្រី</a>
                    <a class="dropdown-item" href="{{ url('employment_statuses') }}"><span class="item-number">12.</span> ស្ថានភាពការងារ</a>
                    <a class="dropdown-item" href="{{ url('skills') }}"><span class="item-number">13.</span> កម្រិតជំនាញ</a>
                    <a class="dropdown-item" href="{{ url('government_employed_doctors') }}"><span class="item-number">14.</span> មន្ត្រីក្របខណ្ឌ</a>
                    <a class="dropdown-item" href="{{ url('hired_medical_officers') }}"><span class="item-number">15.</span> មន្ត្រីកិច្ចសន្យា&ជួល និងជាវេជ្ជសាស្ត្រ</a>
                    <a class="dropdown-item" href="{{ url('hired_not_medical_officers') }}"><span class="item-number">16.</span> មន្ត្រីកិច្ចសន្យា&ជួល និងមិនមែនជាវេជ្ជសាស្ត្រ</a>
                    <a class="dropdown-item" href="{{ route('update.status.view') }}"><span class="item-number">17.</span> អាប់ដេត ស្ថានភាពបុគ្គលិកឬមន្ត្រីសុខាភិបាល</a>
                    <a class="dropdown-item" href="{{ route('report.government_employed_report') }}"><span class="item-number">18.</span> របាយការណ៏</a>
                    <a class="dropdown-item" href="{{ route('chart.employedChartDetail') }}"><span class="item-number">19.</span> ក្រាហ្វិកលម្អិត</a>
                    <a class="dropdown-item" href="{{ route('users.index') }}"><span class="item-number">20.</span> Manage Users</a>
                    <a class="dropdown-item" href="{{ route('backup.index') }}"><span class="item-number">21.</span> Backup Now</a>
                    <a class="dropdown-item" href="{{ route('backup.index_Auto') }}"><span class="item-number">22.</span> Backup Auto</a>

                </div>
            </div>
        </h1>
    </div>
</nav>
 --}}



  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">ប្រពន្ធ័គ្រប់គ្រងមន្ទីពេទ្យ</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../img/profiles/2jTdzb0kpVFOca5ZPO3N.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">ម៉ៅ សុផានិច្ច</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('profile') }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item"><span class="item-number">3.</span> {{ __('Log Out') }}</button>
            </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('provinces') }}">
            <i class="bi bi-person"></i>
            <span>ខេត្តនីមួយៗ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('personal_info_emp') }}">
            <i class="bi bi-person"></i>
            <span>ជីវប្រវត្តិបុគ្គលិកឬមន្ត្រីទូទៅ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('identifications') }}">
            <i class="bi bi-person"></i>
            <span>អត្តសញ្ញាណក្របខណ្ឌ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('educations') }}">
            <i class="bi bi-person"></i>
            <span>កម្រិតវប្បធម៌</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('positions') }}">
            <i class="bi bi-person"></i>
            <span>តួនាទីឬមុខតំណែង</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('departments') }}">
            <i class="bi bi-person"></i>
            <span>ផ្នែក/ឯកទេស</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('buildings') }}">
            <i class="bi bi-person"></i>
            <span>អាគារសុខាភិបាល</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('category_employees') }}">
            <i class="bi bi-person"></i>
            <span>ប្រភេទបុគ្គលិកឬមន្ត្រី</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('employment_statuses') }}">
            <i class="bi bi-person"></i>
            <span>ស្ថានភាពការងារ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('skills') }}">
            <i class="bi bi-person"></i>
            <span>កម្រិតជំនាញ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('government_employed_doctors') }}">
            <i class="bi bi-person"></i>
            <span>មន្ត្រីក្របខណ្ឌ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('hired_medical_officers') }}">
            <i class="bi bi-person"></i>
            <span>មន្ត្រីកិច្ចសន្យា&ជួល និងជាវេជ្ជសាស្ត្រ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('hired_not_medical_officers') }}">
            <i class="bi bi-person"></i>
            <span>មន្ត្រីកិច្ចសន្យា&ជួល និងមិនមែនជាវេជ្ជសាស្ត្រ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('update.status.view') }}">
            <i class="bi bi-person"></i>
            <span>អាប់ដេត ស្ថានភាពបុគ្គលិកឬមន្ត្រីសុខាភិបាល</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('report.government_employed_report') }}">
            <i class="bi bi-person"></i>
            <span>របាយការណ៏</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('chart.employedChartDetail') }}">
            <i class="bi bi-person"></i>
            <span>ក្រាហ្វិកលម្អិត</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('users.index') }}">
            <i class="bi bi-person"></i>
            <span>Manage Users</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('backup.index') }}">
            <i class="bi bi-person"></i>
            <span>Backup Now</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('backup.index_Auto') }}">
            <i class="bi bi-person"></i>
            <span>Backup Auto</span>
        </a>
    </li>


    </ul>

  </aside><!-- End Sidebar-->

























{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}


@include('partials.footer')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('dropdownSearch3');
    const dropdownItemsContainer = document.getElementById('dropdownItems3');
    const dropdownItems = Array.from(dropdownItemsContainer.getElementsByTagName('a'));
    const dropdownToggle = document.getElementById('navbarDropdown3');
    const dropdownMenu = document.querySelector('[aria-labelledby="navbarDropdown3"]');
    let currentFocus = -1;

    // Add click event listener to the profile image
// Use the profileImage ID
const profileImage = document.getElementById('profileImage');
    profileImage.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = "{{ url('profile') }}";
    });


    function filterItems(searchTerm) {
        const term = searchTerm.toLowerCase();
        dropdownItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(term) ? '' : 'none';
        });
    }

    function highlightItem(items) {
        items.forEach((item, index) => {
            if (index === currentFocus) {
                item.classList.add('active');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('active');
            }
        });
    }

    function toggleDropdown(show) {
        if (show) {
            dropdownMenu.classList.add('show');
            dropdownToggle.setAttribute('aria-expanded', 'true');
            searchInput.focus();
        } else {
            dropdownMenu.classList.remove('show');
            dropdownToggle.setAttribute('aria-expanded', 'false');
            currentFocus = -1;
            searchInput.value = '';
            filterItems('');
        }
    }

    searchInput.addEventListener('input', function() {
        filterItems(this.value);
        currentFocus = -1;
    });

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.code === 'Space') {
            e.preventDefault();
            toggleDropdown(true);
        }
    });

    searchInput.addEventListener('keydown', function(e) {
        const visibleItems = dropdownItems.filter(item => item.style.display !== 'none');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentFocus = (currentFocus + 1) % visibleItems.length;
            highlightItem(visibleItems);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentFocus = (currentFocus - 1 + visibleItems.length) % visibleItems.length;
            highlightItem(visibleItems);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (currentFocus > -1 && visibleItems[currentFocus]) {
                visibleItems[currentFocus].click();
                toggleDropdown(false);
            }
        } else if (e.key === 'Escape') {
            toggleDropdown(false);
        }
    });

    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            toggleDropdown(false);
        });
    });

    document.addEventListener('click', function(e) {
        if (!dropdownMenu.contains(e.target) && e.target !== dropdownToggle) {
            toggleDropdown(false);
        }
    });

    dropdownToggle.addEventListener('click', function(e) {
        const isOpen = dropdownMenu.classList.contains('show');
        if (!isOpen) {
            setTimeout(function() {
                searchInput.focus();
            }, 0);
        }
    });

    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const isOpen = dropdownMenu.classList.contains('show');
                if (isOpen) {
                    searchInput.focus();
                }
            }
        });
    });

    observer.observe(dropdownMenu, { attributes: true });
});

</script>
