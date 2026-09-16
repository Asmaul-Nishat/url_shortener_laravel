@php
    use App\Helpers\MenuHelper;

    $menuGroups = MenuHelper::getMenuGroups();

    $currentPath = request()->path();

    $isAdmin = auth()->check() && auth()->user()->isAdmin();

    $dashboardPath = $isAdmin
        ? '/admin/dashboard'
        : '/dashboard';
@endphp

<aside
    id="sidebar"
    class="fixed left-0 top-0 z-50 flex h-screen flex-col border-r border-gray-200 bg-white px-4 text-gray-900 transition-all duration-300 ease-in-out dark:border-gray-800 dark:bg-gray-900"

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

        'max-xl:-translate-x-full':
            !$store.sidebar.isMobileOpen
    }"

    x-data="{
        openSubmenus: {},

        init() {
            this.initializeActiveMenus();
        },

        initializeActiveMenus() {

            const currentPath = window.location.pathname;

            @foreach ($menuGroups as $groupIndex => $menuGroup)

                @foreach ($menuGroup['items'] as $itemIndex => $item)

                    @if (isset($item['subItems']))

                        @foreach ($item['subItems'] as $subItem)

                            if (
                                currentPath === '{{ parse_url($subItem['path'], PHP_URL_PATH) }}'
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

            const key = groupIndex + '-' + itemIndex;

            const newState = !this.openSubmenus[key];

            if (newState) {
                this.openSubmenus = {};
            }

            this.openSubmenus[key] = newState;
        },

        isSubmenuOpen(groupIndex, itemIndex) {

            const key = groupIndex + '-' + itemIndex;

            return this.openSubmenus[key] || false;
        },

        isActive(path) {

            const cleanPath = path.split('?')[0];

            return window.location.pathname === cleanPath;
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

    {{-- ========================================================= --}}
    {{-- LOGO --}}
    {{-- ========================================================= --}}

    <div
        class="flex h-[88px] shrink-0 items-center border-b border-gray-100 dark:border-gray-800"

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
            href="{{ $dashboardPath }}"
            class="flex items-center"
        >

            {{-- Expanded Logo --}}

            <span
                x-show="
                    $store.sidebar.isExpanded ||
                    $store.sidebar.isHovered ||
                    $store.sidebar.isMobileOpen
                "
                x-cloak
                class="whitespace-nowrap text-xl font-bold tracking-tight text-gray-900 dark:text-white"
            >

                <span class="text-brand-600 dark:text-brand-400">
                    URL
                </span>

                Shortener

            </span>


            {{-- Collapsed Logo --}}

            <span
                x-show="
                    !$store.sidebar.isExpanded &&
                    !$store.sidebar.isHovered &&
                    !$store.sidebar.isMobileOpen
                "
                x-cloak
                class="text-xl font-bold tracking-tight text-brand-600 dark:text-brand-400"
            >
                US
            </span>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- NAVIGATION --}}
    {{-- ========================================================= --}}

    <div class="flex flex-1 flex-col overflow-y-auto py-6">

        <nav>

            <div class="flex flex-col gap-6">

                @foreach ($menuGroups as $groupIndex => $menuGroup)

                    <div>

                        {{-- ================================================= --}}
                        {{-- GROUP TITLE --}}
                        {{-- ================================================= --}}

                        <h2
                            class="mb-3 flex h-5 items-center px-3 text-xs font-semibold uppercase tracking-wider text-gray-400"

                            :class="
                                (
                                    !$store.sidebar.isExpanded &&
                                    !$store.sidebar.isHovered &&
                                    !$store.sidebar.isMobileOpen
                                )
                                ? 'justify-center'
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


                            {{-- Collapsed Group Title --}}

                            <template
                                x-if="
                                    !$store.sidebar.isExpanded &&
                                    !$store.sidebar.isHovered &&
                                    !$store.sidebar.isMobileOpen
                                "
                            >
                                <span class="text-gray-300 dark:text-gray-600">
                                    •••
                                </span>
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

                                            class="menu-item group flex w-full items-center gap-3 px-3 py-2.5"

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
                                                ? 'justify-center'
                                                : 'justify-start'
                                            ]"
                                        >

                                            {{-- ================================================= --}}
                                            {{-- ICON --}}
                                            {{-- ================================================= --}}

                                            <span
                                                class="flex h-6 w-6 shrink-0 items-center justify-center"

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


                                            {{-- ================================================= --}}
                                            {{-- TEXT --}}
                                            {{-- ================================================= --}}

                                            <span
                                                x-show="
                                                    $store.sidebar.isExpanded ||
                                                    $store.sidebar.isHovered ||
                                                    $store.sidebar.isMobileOpen
                                                "
                                                x-cloak
                                                class="menu-item-text flex min-w-0 flex-1 items-center gap-2"
                                            >

                                                <span class="truncate">
                                                    {{ __($item['name']) }}
                                                </span>

                                                @if (!empty($item['new']))

                                                    <span
                                                        class="shrink-0 rounded-md bg-brand-100 px-2 py-0.5 text-[10px] font-semibold uppercase text-brand-600 dark:bg-brand-500/20 dark:text-brand-400"
                                                    >
                                                        {{ __('new') }}
                                                    </span>

                                                @endif

                                            </span>


                                            {{-- ================================================= --}}
                                            {{-- ARROW --}}
                                            {{-- ================================================= --}}

                                            <svg
                                                x-show="
                                                    $store.sidebar.isExpanded ||
                                                    $store.sidebar.isHovered ||
                                                    $store.sidebar.isMobileOpen
                                                "
                                                x-cloak

                                                class="ml-auto h-5 w-5 shrink-0 transition-transform duration-200"

                                                :class="{
                                                    'rotate-180 text-brand-500':
                                                        isSubmenuOpen(
                                                            {{ $groupIndex }},
                                                            {{ $itemIndex }}
                                                        ),

                                                    'text-gray-400':
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
                                                class="mt-2 space-y-1 border-l border-gray-200 pl-4 dark:border-gray-800"
                                            >

                                                @foreach ($item['subItems'] as $subItem)

                                                    @php
                                                        $subItemPath = parse_url(
                                                            $subItem['path'],
                                                            PHP_URL_PATH
                                                        );
                                                    @endphp

                                                    <li>

                                                        <a
                                                            href="{{ $subItem['path'] }}"

                                                            class="menu-dropdown-item flex items-center"

                                                            :class="
                                                                isActive(
                                                                    '{{ $subItemPath }}'
                                                                )
                                                                ? 'menu-dropdown-item-active'
                                                                : 'menu-dropdown-item-inactive'
                                                            "
                                                        >

                                                            {{-- Submenu Text --}}

                                                            <span class="truncate">
                                                                {{ __($subItem['name']) }}
                                                            </span>


                                                            {{-- Submenu Badges --}}

                                                            <span
                                                                class="ml-auto flex shrink-0 items-center gap-1"
                                                            >

                                                                @if (!empty($subItem['new']))

                                                                    <span
                                                                        :class="
                                                                            isActive(
                                                                                '{{ $subItemPath }}'
                                                                            )
                                                                            ? 'menu-dropdown-badge menu-dropdown-badge-active'
                                                                            : 'menu-dropdown-badge menu-dropdown-badge-inactive'
                                                                        "
                                                                    >
                                                                        {{ __('new') }}
                                                                    </span>

                                                                @endif


                                                                @if (!empty($subItem['pro']))

                                                                    <span
                                                                        :class="
                                                                            isActive(
                                                                                '{{ $subItemPath }}'
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

                                            class="menu-item group flex w-full items-center gap-3 px-3 py-2.5"

                                            :class="[
                                                isActive(
                                                    '{{ parse_url($item['path'], PHP_URL_PATH) }}'
                                                )
                                                ? 'menu-item-active'
                                                : 'menu-item-inactive',

                                                (
                                                    !$store.sidebar.isExpanded &&
                                                    !$store.sidebar.isHovered &&
                                                    !$store.sidebar.isMobileOpen
                                                )
                                                ? 'justify-center'
                                                : 'justify-start'
                                            ]"
                                        >

                                            {{-- ================================================= --}}
                                            {{-- ICON --}}
                                            {{-- ================================================= --}}

                                            <span
                                                class="flex h-6 w-6 shrink-0 items-center justify-center"

                                                :class="
                                                    isActive(
                                                        '{{ parse_url($item['path'], PHP_URL_PATH) }}'
                                                    )
                                                    ? 'menu-item-icon-active'
                                                    : 'menu-item-icon-inactive'
                                                "
                                            >
                                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                                            </span>


                                            {{-- ================================================= --}}
                                            {{-- TEXT --}}
                                            {{-- ================================================= --}}

                                            <span
                                                x-show="
                                                    $store.sidebar.isExpanded ||
                                                    $store.sidebar.isHovered ||
                                                    $store.sidebar.isMobileOpen
                                                "
                                                x-cloak
                                                class="menu-item-text flex min-w-0 flex-1 items-center gap-2"
                                            >

                                                <span class="truncate">
                                                    {{ __($item['name']) }}
                                                </span>

                                                @if (!empty($item['new']))

                                                    <span
                                                        class="shrink-0 rounded-md bg-brand-100 px-2 py-0.5 text-[10px] font-semibold uppercase text-brand-600 dark:bg-brand-500/20 dark:text-brand-400"
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