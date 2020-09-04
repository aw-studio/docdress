<div class="inline-block relative w-full pt-2 dd-version-select">
    <select id="dd-version" onchange="changeVersion(this.value)" class="rounded-lg block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 h-10 pr-8 leading-tight focus:outline-none">
        @foreach($versions as $version => $title)
        <option value="{{ $version }}" {{ $currentVersion == $version ? 'selected="selected"' : '' }}>
            {{ $title }}
        </option>
        @endforeach
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 pt-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
    </div>
</div>

<script>
currentVersion = "{{ $currentVersion }}";
</script>

<x-script>
    function changeVersion(version) {
        Turbolinks.visit(window.location.pathname.replace(currentVersion, version), {action:'replace'})
    }
</x-script>

<x-style lang="scss">
.dd-version-select{
    select{
        line-height: 2.5rem;
    }
}
</x-style>