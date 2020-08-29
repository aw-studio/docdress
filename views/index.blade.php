{!! $index !!}

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
            let current = document.querySelector('aside.sidebar ul ul.expanded');
            
            document.querySelectorAll('aside.sidebar ul ul').forEach(function(h) {
                h.classList.remove('expanded')    
            });
            let el = this.parentNode.querySelector('ul');
            if(current != el) {
                el.classList.add('expanded');
            }
        });
    });

    let firstList = true
    document.querySelectorAll('.content > ul').forEach(function(node) {
        if(firstList) {
            return (firstList = false);
        }
        node.classList.add('list')
    });
});
</x-script>