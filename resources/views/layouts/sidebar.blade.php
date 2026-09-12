@php
    use App\Helpers\MenuHelper;

    $menuGroups = MenuHelper::getMenuGroups();

    // Get current path
    $currentPath = request()->path();
@endphp

<aside
    id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 start-0
           bg-white dark:bg-gray-900
           dark:border-gray-800
           text-gray-900
           h-screen
           transition-all duration-300 ease-in-out
           z-99999
           ltr:border-r rtl:border-l
           border-gray-200"

    :class="{
        'w-[290px]':
            $store.sidebar.isExpanded ||
            $store.sidebar.isHovered ||
            $store.sidebar.isMobileOpen,

        'w-[90px]':
            !$store.sidebar.isExpanded &&
            !$store.sidebar.isHovered &&
            !$store.sidebar.isMobileOpen,

        'translate-x-0':
            $store.sidebar.isMobileOpen,

        'max-xl:-translate-x-full max-xl:rtl:translate-x-full':
            !$store.sidebar.isMobileOpen
    }"

    x-data="{
        openSubmenus: {},

        init() {
            this.initializeActiveMenus();
        },

        initializeActiveMenus() {

            const currentPath = '{{ $currentPath }}';

            @foreach ($menuGroups as $groupIndex => $menuGroup)

                @foreach ($menuGroup['items'] as $itemIndex => $item)

                    @if (isset($item['subItems']))

                        @foreach ($item['subItems'] as $subItem)

                            if (
                                currentPath === '{{ ltrim($subItem['path'], '/') }}'
                                ||
                                window.location.pathname === '{{ $subItem['path'] }}'
                            ) {
                                this.openSubmenus[
                                    '{{ $groupIndex }}-{{ $itemIndex }}'
                                ] = true;
                            }

                        @endforeach

                    @endif

                @endforeach

            @endforeach
        },

        toggleSubmenu(groupIndex, itemIndex) {

            const key =
                groupIndex + '-' + itemIndex;

            const newState =
                !this.openSubmenus[key];

            // Close all other submenus
            if (newState) {
                this.openSubmenus = {};
            }

            this.openSubmenus[key] = newState;
        },

        isSubmenuOpen(groupIndex, itemIndex) {

            const key =
                groupIndex + '-' + itemIndex;

            return this.openSubmenus[key] || false;
        },

        isActive(path) {

            return (
                window.location.pathname === path
                ||
                '{{ $currentPath }}' ===
                path.replace(/^\//, '')
            );
        }
    }"

    @mouseenter="
        if (!$store.sidebar.isExpanded) {
            $store.sidebar.setHovered(true);
        }
    "

    @mouseleave="
        $store.sidebar.setHovered(false);
    "
>

    {{-- ===================================================== --}}
    {{-- LOGO SECTION --}}
    {{-- ===================================================== --}}

    <div
        class="pt-8 pb-7 flex items-center gap-2"
        :class="
            (
                !$store.sidebar.isExpanded &&
                !$store.sidebar.isHovered &&
                !$store.sidebar.isMobileOpen
            )
            ? 'justify-center'
            : 'justify-between'
        "
    >

        <a
            href="{{ url('/dashboard') }}"
            class="flex items-center gap-2"
        >

            {{-- Expanded Logo --}}
            <span
                x-show="
                    $store.sidebar.isExpanded ||
                    $store.sidebar.isHovered ||
                    $store.sidebar.isMobileOpen
                "
                x-cloak
                class="text-xl font-bold text-gray-800 dark:text-white"
            >
                URL Shortener
            </span>

            {{-- Collapsed Logo --}}
            <span
                x-show="
                    !$store.sidebar.isExpanded &&
                    !$store.sidebar.isHovered &&
                    !$store.sidebar.isMobileOpen
                "
                x-cloak
                class="text-xl font-bold text-gray-800 dark:text-white"
            >
                US
            </span>

        </a>

    </div>


    {{-- ===================================================== --}}
    {{-- NAVIGATION --}}
    {{-- ===================================================== --}}

    <div
        class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
    >

        <nav class="mb-6">

            <div class="flex flex-col gap-4">

                @foreach ($menuGroups as $groupIndex => $menuGroup)

                    <div>

                        {{-- ================================================= --}}
                        {{-- MENU GROUP TITLE --}}
                        {{-- ================================================= --}}

                        <h2
                            class="mb-4 text-xs uppercase flex leading-[20px] text-gray-400"

                            :class="
                                (
                                    !$store.sidebar.isExpanded &&
                                    !$store.sidebar.isHovered &&
                                    !$store.sidebar.isMobileOpen
                                )
                                ? 'lg:justify-center'
                                : 'justify-start'
                            "
                        >

                            {{-- Expanded Group Title --}}
                            <template
                                x-if="
                                    $store.sidebar.isExpanded ||
                                    $store.sidebar.isHovered ||
                                    $store.sidebar.isMobileOpen
                                "
                            >
                                <span>
                                    {{ __($menuGroup['title']) }}
                                </span>
                            </template>


                            {{-- Collapsed Group Icon --}}
                            <template
                                x-if="
                                    !$store.sidebar.isExpanded &&
                                    !$store.sidebar.isHovered &&
                                    !$store.sidebar.isMobileOpen
                                "
                            >

                                <svg
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >

                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                        fill="currentColor"
                                    />

                                </svg>

                            </template>

                        </h2>


                        {{-- ================================================= --}}
                        {{-- MENU ITEMS --}}
                        {{-- ================================================= --}}

                        <ul class="flex flex-col gap-1">

                            @foreach ($menuGroup['items'] as $itemIndex => $item)

                                <li>

                                    {{-- ================================================= --}}
                                    {{-- ITEM WITH SUBMENU --}}
                                    {{-- ================================================= --}}

                                    @if (isset($item['subItems']))

                                        <button
                                            type="button"

                                            @click="
                                                toggleSubmenu(
                                                    {{ $groupIndex }},
                                                    {{ $itemIndex }}
                                                )
                                            "

                                            class="menu-item group w-full"

                                            :class="[
                                                isSubmenuOpen(
                                                    {{ $groupIndex }},
                                                    {{ $itemIndex }}
                                                )
                                                ? 'menu-item-active'
                                                : 'menu-item-inactive',

                                                (
                                                    !$store.sidebar.isExpanded &&
                                                    !$store.sidebar.isHovered &&
                                                    !$store.sidebar.isMobileOpen
                                                )
                                                ? 'xl:justify-center'
                                                : 'xl:justify-start'
                                            ]"
                                        >

                                            {{-- Menu Icon --}}
                                            <span
                                                :class="
                                                    isSubmenuOpen(
                                                        {{ $groupIndex }},
                                                        {{ $itemIndex }}
                                                    )
                                                    ? 'menu-item-icon-active'
                                                    : 'menu-item-icon-inactive'
                                                "
                                            >

                                                {!! MenuHelper::getIconSvg($item['icon']) !!}

                                            </span>


                                            {{-- Menu Text --}}
                                            <span
                                                x-show="
                                                    $store.sidebar.isExpanded ||
                                                    $store.sidebar.isHovered ||
                                                    $store.sidebar.isMobileOpen
                                                "
                                                x-cloak
                                                class="menu-item-text flex items-center gap-2"
                                            >

                                                {{ __($item['name']) }}


                                                {{-- New Badge --}}
                                                @if (!empty($item['new']))

                                                    <span
                                                        class="absolute ltr:right-10 rtl:left-10"

                                                        :class="
                                                            isActive(
                                                                '{{ $item['path'] ?? '' }}'
                                                            )
                                                            ? 'menu-dropdown-badge menu-dropdown-badge-active'
                                                            : 'menu-dropdown-badge menu-dropdown-badge-inactive'
                                                        "
                                                    >
                                                        {{ __('new') }}
                                                    </span>

                                                @endif

                                            </span>


                                            {{-- Arrow --}}
                                            <svg
                                                x-show="
                                                    $store.sidebar.isExpanded ||
                                                    $store.sidebar.isHovered ||
                                                    $store.sidebar.isMobileOpen
                                                "
                                                x-cloak

                                                class="ltr:ml-auto rtl:mr-auto w-5 h-5 transition-transform duration-200"

                                                :class="{
                                                    'rotate-180 text-brand-500':
                                                        isSubmenuOpen(
                                                            {{ $groupIndex }},
                                                            {{ $itemIndex }}
                                                        ),

                                                    'text-gray-500 dark:text-gray-400':
                                                        !isSubmenuOpen(
                                                            {{ $groupIndex }},
                                                            {{ $itemIndex }}
                                                        )
                                                }"

                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >

                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />

                                            </svg>

                                        </button>


                                        {{-- ================================================= --}}
                                        {{-- SUBMENU --}}
                                        {{-- ================================================= --}}

                                        <div
                                            x-show="
                                                isSubmenuOpen(
                                                    {{ $groupIndex }},
                                                    {{ $itemIndex }}
                                                )
                                                &&
                                                (
                                                    $store.sidebar.isExpanded ||
                                                    $store.sidebar.isHovered ||
                                                    $store.sidebar.isMobileOpen
                                                )
                                            "
                                            x-collapse
                                        >

                                            <ul
                                                class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9"
                                            >

                                                @foreach ($item['subItems'] as $subItem)

                                                    <li>

                                                        <a
                                                            href="{{ $subItem['path'] }}"

                                                            class="menu-dropdown-item"

                                                            :class="
                                                                isActive(
                                                                    '{{ $subItem['path'] }}'
                                                                )
                                                                ? 'menu-dropdown-item-active'
                                                                : 'menu-dropdown-item-inactive'
                                                            "
                                                        >

                                                            {{ __($subItem['name']) }}


                                                            <span
                                                                class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto"
                                                            >

                                                                {{-- New --}}
                                                                @if (!empty($subItem['new']))

                                                                    <span
                                                                        :class="
                                                                            isActive(
                                                                                '{{ $subItem['path'] }}'
                                                                            )
                                                                            ? 'menu-dropdown-badge menu-dropdown-badge-active'
                                                                            : 'menu-dropdown-badge menu-dropdown-badge-inactive'
                                                                        "
                                                                    >
                                                                        {{ __('new') }}
                                                                    </span>

                                                                @endif


                                                                {{-- Pro --}}
                                                                @if (!empty($subItem['pro']))

                                                                    <span
                                                                        :class="
                                                                            isActive(
                                                                                '{{ $subItem['path'] }}'
                                                                            )
                                                                            ? 'menu-dropdown-badge-pro menu-dropdown-badge-pro-active'
                                                                            : 'menu-dropdown-badge-pro menu-dropdown-badge-pro-inactive'
                                                                        "
                                                                    >
                                                                        {{ __('pro') }}
                                                                    </span>

                                                                @endif

                                                            </span>

                                                        </a>

                                                    </li>

                                                @endforeach

                                            </ul>

                                        </div>


                                    {{-- ================================================= --}}
                                    {{-- NORMAL MENU ITEM --}}
                                    {{-- ================================================= --}}

                                    @else

                                        <a
                                            href="{{ $item['path'] }}"

                                            class="menu-item group"

                                            :class="[
                                                isActive(
                                                    '{{ $item['path'] }}'
                                                )
                                                ? 'menu-item-active'
                                                : 'menu-item-inactive',

                                                (
                                                    !$store.sidebar.isExpanded &&
                                                    !$store.sidebar.isHovered &&
                                                    !$store.sidebar.isMobileOpen
                                                )
                                                ? 'xl:justify-center'
                                                : 'xl:justify-start'
                                            ]"
                                        >

                                            {{-- Icon --}}
                                            <span
                                                :class="
                                                    isActive(
                                                        '{{ $item['path'] }}'
                                                    )
                                                    ? 'menu-item-icon-active'
                                                    : 'menu-item-icon-inactive'
                                                "
                                            >

                                                {!! MenuHelper::getIconSvg($item['icon']) !!}

                                            </span>


                                            {{-- Text --}}
                                            <span
                                                x-show="
                                                    $store.sidebar.isExpanded ||
                                                    $store.sidebar.isHovered ||
                                                    $store.sidebar.isMobileOpen
                                                "
                                                x-cloak
                                                class="menu-item-text flex items-center gap-2"
                                            >

                                                {{ __($item['name']) }}


                                                {{-- New Badge --}}
                                                @if (!empty($item['new']))

                                                    <span
                                                        class="ltr:ml-2 rtl:mr-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-500 text-white"
                                                    >
                                                        {{ __('new') }}
                                                    </span>

                                                @endif

                                            </span>

                                        </a>

                                    @endif

                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endforeach

            </div>

        </nav>

    </div>

</aside>


{{-- ========================================================= --}}
{{-- MOBILE SIDEBAR BACKDROP --}}
{{-- ========================================================= --}}

<div
    x-show="$store.sidebar.isMobileOpen"

    x-cloak

    @click="$store.sidebar.setMobileOpen(false)"

    class="fixed z-50 h-screen w-full bg-gray-900/50"
></div>