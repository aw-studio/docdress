
@include('docdress::algolia_template')

<input id="dd-search" class="{{ $class }}" type="text" name="search" placeholder="Search Docs">

<script>
window.version = "{{ $version }}";
@isset($config->algolia_app_key)
window.algolia = {!! json_encode([
    'app_key' => $config->algolia_app_key,
    'app_id' => $config->algolia_app_id ?? 'BH4D9OD16A'
]) !!};
@endisset
</script>
<script src="/docdress/js/search.js"></script>

<x-style lang="scss">
.twitter-typeahead{
    width: 100%;
    position: relative;
}
.tt-dropdown-menu {
    width: 100%;
    top: calc(100% + 0.5rem) !important;
    z-index:1;
    background: #f6f8fb;
    width: 100%;
    position: absolute;
    border-radius: .5rem;
    border: 1px solid #cbd5e0;
    left: 0;
    right: 0;

    .tt-suggestion {
        &:first-child .dd-search-result {
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
        }
        &:last-child .dd-search-result{
            border-bottom: none !important;
        }
    } 
    .dd-search-result{
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #cbd5e0 !important;
        cursor:pointer;

        &:hover{
            background: #edf3fc;
        }

        &__title {
            font-weight: 600;
            margin-bottom: 0.125rem;
            color: #000000cc;
        }
        &__subtitle{
            margin-bottom: 0.125rem;
            &::before {
                content: "#";
                font-weight: 400;
                margin-left: -13px;
                margin-top: 1px;
                position: absolute;
                font-size: 16px;
                color: var(--primary);
                opacity: .6;
            }
        }
        &__title em, &__subtitle em {
            font-style: normal;
            position: relative;
            &:before {
                content: "";
                width: 100%;
                height: 100%;
                position: absolute;
                left: 0;
                background-color: var(--primary);
                opacity: 0.15;
                
            }
        }
        &__text{
            font-size: 14px;
            background: #fdfeff;
            padding: .25rem;
            border-radius: 4px;

            em{
                font-style: normal;
                font-weight: bold;
            }
        }
    }
}
</x-style>