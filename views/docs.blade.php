@extends('docdress::layout')

@section('content')
    <div class="layout-docs relative" id="docs">

        <div class="container mx-auto flex">
            
            <aside class="sidebar sticky overflow-visible top-0 pt-12">
                <div class="logo">
                    <a href="/" class="text-3xl text-black no-underline">Docs</a>
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
    </x-script>
@stop
