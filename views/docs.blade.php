@extends('docdress::layout')

@section('content')
    <div class="layout-docs relative" id="docs">

        <div class="container mx-auto flex">
            
            <aside class="sidebar sticky overflow-visible top-0 pt-12">
                <div class="logo">
                    <a href="/" class="text-3xl text-purple">Fjuse</a>
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
                    <div class="w-1/4 pl-4">
                        @include('docdress::version')
                    </div>
                </header>

                <div class="content w-3/4">
                    {!! $content !!}
                </div>
                
            </section>
            
        </div>

    </div>
@stop
