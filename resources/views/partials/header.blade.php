<!-- resources/views/partials/header.blade.php -->
 
<nav class="navbar">

    <div class="container">


        <h1 class="nav-item dropdown">
                    



            <a class="nav-item dropdown nav-link dropdown-toggle custom-font007A" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                កន្លែងផ្ទុកទី១ 
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                <li><a class="dropdown-item" href="/">Home</a></li>
                <li><a class="dropdown-item" href="/about">About</a></li>
                <li><a class="dropdown-item" href="/contact">Contact</a></li>
            </ul>
        </h1>

        <h1 class="nav-item dropdown">
            <a class="nav-item dropdown nav-link dropdown-toggle custom-font007A" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                កន្លែងផ្ទុកទី២   
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                <li><a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profile') }}</a></li>
                <li><a class="dropdown-item" href="{{ url('settings') }}">Settings</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                    </form>
                </li>
                <li><a class="dropdown-item" href="{{ url('ajax_product')}}">AJAX Product</a></li>
                <li><a class="dropdown-item" href="{{ url('provinces') }}">ខេត្តនីមួយៗ</a></li>
                <li><a class="dropdown-item" href="{{ url('personal_info_emp') }}">ជីវប្រវត្តិបុគ្គលិកឬមន្ត្រីទូទៅ</a></li>
            </ul>
        </h1>

        <h1 class="nav-item dropdown">
            <a class="nav-item dropdown nav-link dropdown-toggle custom-font007A" href="#" id="navbarDropdown3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
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

                    <!-- <a class="dropdown-item" href="{{ route('report.hired_medical_officer_report') }}"><span class="item-number">20.</span> របាយការណ៏មន្ត្រីសុខាភិបាលជាប់កិច្ចសន្យា</a>
                    <a class="dropdown-item" href="{{ route('report.hired_not_medical_officer_report') }}"><span class="item-number">21.</span> របាយការណ៍មន្ត្រីសុខាភិបាលជាប់កិច្ចសន្យា មិនមែនវេជ្ជសាស្ត្រ</a>
                    <a class="dropdown-item" href="{{ route('report.government_employed_report_by_building') }}"><span class="item-number">22.</span> របាយការណ៍មន្ត្រីក្របខណ្ឌតាមអាគារ</a>
                    
                  
                    <a class="dropdown-item" href="{{ route('EmployedReport.detail') }}">
                        <span class="item-number">24.</span> របាយការណ៍មន្ត្រី
                    </a>

                    <a class="dropdown-item" href="{{ route('EmployedReport.detail_second') }}">
                        <span class="item-number">25.</span> របាយការណ៍មន្ត្រីលម្អិត
                    </a>
                  -->

                </div>
            </div>
        </h1>
    </div>
</nav>

<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .dropdown-item .item-number {
        margin-right: 5px;
        font-weight: bold;
        color: #007bff;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('dropdownSearch3');
    const dropdownItemsContainer = document.getElementById('dropdownItems3');
    const dropdownItems = Array.from(dropdownItemsContainer.getElementsByTagName('a'));
    const dropdownToggle = document.getElementById('navbarDropdown3');
    const dropdownMenu = document.querySelector('[aria-labelledby="navbarDropdown3"]');
    let currentFocus = -1;

  
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