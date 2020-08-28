<div class="pt-2 relative mx-auto text-gray-600 dd-search">
    <input class="border border-gray-400 hover:border-gray-500 bg-white h-10 px-4 pr-16 rounded-lg text-sm focus:outline-none w-full" type="text" name="search" placeholder="Search Docs">
    <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
        <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
        </svg>
    </button>
</div>

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