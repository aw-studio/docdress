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

            <section class="p-24 flex-1">
                <div class="content w-3/4">

                {!! $content !!}

                </div>
                <div class="controls">
                    <select class="w-100">
                        <option value="2.4">2.4</option>
                    </select>
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
                node.parentNode.style.display = 'block'
                node.classList.add('active')
            }
        });

        document.querySelectorAll('aside.sidebar h2').forEach(function(heading) {
            heading.addEventListener('click', function(event) {
                document.querySelectorAll('aside.sidebar ul ul').forEach(function(h) {
                    h.style.display = 'none'
                })
                let el = this.parentNode.querySelector('ul')
                el.style.display = 'block'
                
            })
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
