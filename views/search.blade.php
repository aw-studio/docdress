<div class="pt-2 relative mx-auto text-gray-600 dd-search">
    <input class="border border-gray-400 hover:border-gray-500 bg-white h-10 px-4 pr-16 rounded-lg text-sm focus:outline-none w-full" type="text" name="search" placeholder="Search Docs">
    <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
        <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
        </svg>
    </button>

    <div class="dd-search-results absolute rounded-lg border-gray-500 border left-0 right-0 px-6">
        <div class="dd-search-result border-gray-500">
            <h5 class="dd-search-result__title">Input</h5>
            <div class="dd-search-result__subtitle color-gray-900">
                Introduction > lol
            </div>
            <div class="dd-search-result__text">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam excepturi possimus distinctio consectetur quisquam unde reiciendis perspiciatis. Maiores, inventore, nemo dolorum ex doloribus eligendi, magnam pariatur ullam ipsa hic itaque?
            </div>
        </div>

        <div class="dd-search-result border-gray-500">
            <h5 class="dd-search-result__title">Input</h5>
            <div class="dd-search-result__subtitle color-gray-900">
                abc > lol
            </div>
            <div class="dd-search-result__text">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam excepturi possimus distinctio consectetur quisquam unde reiciendis perspiciatis. Maiores, inventore, nemo dolorum ex doloribus eligendi, magnam pariatur ullam ipsa hic itaque?
            </div>
        </div>
    </div>
</div>

<x-script>

</x-script>

<x-style lang="scss">
.dd-search{
    .dd-search-results {
        top: calc(100% + 0.5rem);
        z-index:1;
        background: #f6f8fb;
    }

    .dd-search-result{
        padding: 1rem 1.5rem;
        border-bottom-width: 1px;
        cursor:pointer;

        &:hover{
            background: #edf3fc;
        }

        &:last-child{
            border-bottom-width: 0;
        }

        &__title {
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
                color: #4951f2;
                opacity: .6;
            }
        }
        &__text{
            font-size: 14px;
        }
    }
}
</x-style>