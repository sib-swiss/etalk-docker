<nav
    class="
  relative
  w-full
  flex flex-wrap
  items-center
  justify-between
  py-4
  bg-gray-100
  text-gray-500
  hover:text-gray-700
  focus:text-gray-700
  border-t-4 border-[#0d658c]
    shadow-lg
  navbar navbar-expand-lg navbar-light
  ">
    <div class="container mx-auto flex flex-wrap items-center justify-between px-6">
        <button
            class="
      navbar-toggler
      text-gray-500
      border-0
      hover:shadow-none hover:no-underline
      py-2
      px-2.5
      bg-transparent
      focus:outline-none focus:ring-0 focus:shadow-none focus:no-underline
    "
            type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" class="w-6"
                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="currentColor"
                    d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z">
                </path>
            </svg>
        </button>
        <div class="collapse navbar-collapse flex-grow items-center" id="navbarSupportedContent">

            <!-- Left links -->
            <ul class="navbar-nav flex flex-col pl-0 list-style-none mr-auto">
                @foreach ([
        'home' => 'Home',
        'introduction' => 'Introduction',
        'mode-demploi' => 'How does it work?',
        'mode-demploifr' => "Mode d'emploi",
        'contact' => 'Contact us',
    ]
    as $routeName => $text)
                    <li class="nav-item p-2">
                        <a class="nav-link 
                                    @if (Illuminate\Support\Facades\Route::currentRouteName() === $routeName) 
                                        text-white bg-[#511C69]
                                    @else
                                        text-gray-500                                        
                                    @endif
                                    hover:text-white hover:bg-[#511C69] 
                                    focus:text-gray-700 p-6"
                            href="{{ route($routeName) }}">{{ $text }}</a>
                    </li>
                @endforeach
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->


    </div>
</nav>