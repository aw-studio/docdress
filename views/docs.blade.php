@extends('docdress::layout')

@section('content')
    <div class="layout-docs relative" id="docs">

        <div class="container mx-auto flex">
            
            <aside class="sidebar sticky overflow-visible top-0 pt-12">
                <div class="logo">
                    <a href="/{{ $config->route_prefix }}" class="text-3xl text-black no-underline" data-turbolinks="false">Docs</a>
                </div>
                
                <nav class="absolute overflow-y-scroll bottom-0 left-0 right-0 py-6" style="top:6rem;">
                    
                    @include('docdress::index')
                    
                </nav>
            </aside>

            <section class="p-24 pt-12 flex-1">
                <header class="flex pb-12">
                    <div class="w-3/4">
                        @include('docdress::search')
                    </div>
                    <div class="w-1/4 pl-4 flex">
                        @include('docdress::version')

                        <a class="leading-10 pt-2 px-4 text-black" href="https://github.com/{{ $repo }}" target="_blank">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </header>

                <div class="content w-3/4">
                    {!! $content !!}
                </div>
                
            </section>
            
        </div>

    </div>

    <x-script>
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
                window.history.pushState(null, null, '#'+hash);
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
