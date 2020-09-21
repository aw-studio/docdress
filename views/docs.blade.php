@extends('docdress::layout')

@section('content')
    <div class="layout-docs relative" id="docs">

        <div id="burger" class="fixed cursor-pointer z-20 p-2 h-10 w-10 rounded-full inline-block text-center align-middle lg:hidden" style="background: #f5f5fa;bottom: 1rem;left: 1rem; color: var(--primary)">
            <i class="fas fa-bars "></i>    
        </div>

        <div class="container mx-auto block lg:flex">
            
            <aside class="sidebar fixed z-10 overflow-visible top-0 pt-12 block lg:sticky" style="left:-250px;">
                <div class="logo">
                    @include('docdress::logo')
                </div>
                
                <nav class="absolute overflow-y-scroll bottom-0 left-0 right-0 py-6" style="top:6rem;">
                    
                    @include('docdress::index')
                    
                </nav>
            </aside>

            <section class="p-10 lg:p-24 pt-12 flex-1">
                <header class="block lg:flex pb-12">
                    
                    <div class="
                        w-full lg:w-3/4
                    ">
                        @include('docdress::search')
                    </div>
                    <div class="
                        w-full lg:w-1/4 lg:pl-4 flex
                    ">
                        @include('docdress::version')
                        <a class="leading-10 pt-2 px-4 text-black" href="{{ $blob ?? "https://github.com/{$repo}" }}" target="_blank">
                            <i class="fab fa-github"></i>
                        </a>
                        @if($edit ?? false)
                        <a class="leading-10 pt-2 pr-4 text-black" href="{{ $edit }}" target="_blank">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @endif
                    </div>
                </header>

                <div class="content w-full lg:w-3/4">
                    {!! $content !!}
                </div>
                
            </section>
            
        </div>

    </div>

    <x-style lang="scss">
        aside.sidebar {
            transition: left 0.25s ease;

            &__show{
                left: 0 !important;
            }
        }
        .burger__in-sidebar{
            transition: left 0.25s ease;
            left: 190px !important;
        }
    </x-style>

    <x-script>
        ready(function() {
            let burger = document.getElementById('burger')

            burger.addEventListener('click', function() {
                let sidebar = document.querySelector('aside.sidebar')

                sidebar.classList.toggle('sidebar__show')
                burger.classList.toggle('burger__in-sidebar')
            })
        });
        ready(function() {
            let section = window.location.href.split('#')[1];
            if(!section) {
                return;
            }
            document.querySelector('a[name="'+section+'"]').scrollIntoView(true)

            
        });
        function isElementAboveScreen(el) {
            //special bonus for those using jQuery
            if (typeof jQuery === "function" && el instanceof jQuery) {
                el = el[0];
            }
            let rect = el.getBoundingClientRect();

            return rect.top < 25;
        };
        function updateHash() {
            let elements = []
            let hash = null;
            document.querySelectorAll('.content h2').forEach(function(el) {elements.push(el)});
            elements.forEach(function(el) {
                
                if(!isElementAboveScreen(el)) {
                    return;
                }
                
                if (!window.history.pushState) {
                    return;    
                }
                hash = el.id;

                console.log(hash)
                
            });

            if(hash !== null) {
                window.history.replaceState({}, document.title, '#'+hash);
            } else {
                removeHash()
            }
        }
        function removeHash () { 
            var scrollV, scrollH, loc = window.location;
            if ("pushState" in history)
                history.pushState("", document.title, loc.pathname + loc.search);
            else {
                // Prevent scrolling by storing the page's current scroll offset
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;
        
                loc.hash = "";
        
                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        }
        var isScrolling;
        window.addEventListener('scroll', function(e) {
            // Clear our timeout throughout the scroll
	        window.clearTimeout( isScrolling );

            // Set a timeout to run after scrolling ends
            isScrolling = setTimeout(function() {

                updateHash()
                

            }, 100);
        });
    </x-script>
@stop
