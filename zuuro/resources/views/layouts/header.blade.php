<header class="header-area header-sticky">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <nav class="main-nav">
                                <!-- ***** Logo Start ***** -->
                                <a href="index.html" class="logo">
                                    <img src="{{ asset('images/templatemo-eduwell.png') }}" alt="EduWell Template">
                                </a>
                                <!-- ***** Logo End ***** -->
                                <!-- ***** Menu Start ***** -->
                                <ul class="nav">
                                    <li class="scroll-to-section"><a href="/" class="active">Home</a></li>
                                    <li class="scroll-to-section"><a href="/user_services">Services</a></li>
                                    <li class="scroll-to-section"><a href="/user_about_us">About Us</a></li>
                                    <li class="scroll-to-section"><a href="/countact_us">Contact-us</a></li> 
                                    @if (Route::has('login'))
                                        @auth
                                            <li class="scroll-to-section"><a href="{{ url('/home') }}">Home</a></li> 
                                        @else
                                            <li class="scroll-to-section"><a href="{{ route('login') }}">Login</a></li> 
                                        @endauth
                                @endif
                                    
                                </ul>        
                                <a class='menu-trigger'>
                                    <span>Menu</span>
                                </a>
                                <!-- ***** Menu End ***** -->
                            </nav>
                        </div>
                    </div>
                </div>
            </header>