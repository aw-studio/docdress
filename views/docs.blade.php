@extends('docdress::layout')

@section('content')
    <div class="layout-docs relative" id="docs">

        <div class="container mx-auto flex">
            
            <aside class="sidebar sticky overflow-visible top-0 pt-12">
                <div class="logo">
                    <a href="/" class="text-3xl text-purple">Fjuse</a>
                </div>
                
                <nav class="absolute overflow-y-scroll bottom-0 left-0 right-0 py-6" style="top:6rem;">
                    <div>
                        {!! $index !!}
                    </div>
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
    
    <x-script>
    ready(function() {
        document.querySelectorAll('aside.sidebar ul li li').forEach(function(node) {
            let child = node.querySelector('a')
            if(child.href != (window.location.origin+window.location.pathname)) {
                
            } else {
                node.parentNode.classList.add('expanded')
                node.classList.add('active')
            }
        });

        document.querySelectorAll('aside.sidebar h2').forEach(function(heading) {
            heading.addEventListener('click', function(event) {
                document.querySelectorAll('aside.sidebar ul ul').forEach(function(h) {
                    h.classList.remove('expanded')
                    // h.style['max-height'] = 0
                })
                let el = this.parentNode.querySelector('ul')
                el.classList.add('expanded')
            });
        });

        let firstList = true
        document.querySelectorAll('.content > ul').forEach(function(node) {
            console.log(node, firstList)
            if(firstList) {
                return (firstList = false);
            }
            node.classList.add('list')
        });
    })
    </x-script>
@stop
