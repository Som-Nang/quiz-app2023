<script setup>
    import {Link} from '@inertiajs/vue3'
</script>

<template>
    <div class="navbar bg-gray-100 justify-between px-16">
        <div class="navbar-start flex ">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16"
                        />
                    </svg>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
                >
                    <li><a>Item 1</a></li>
                    <li>
                        <a>Parent</a>
                        <ul class="p-2">
                            <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </li>
                    <li><a>Item 3</a></li>
                </ul>
            </div>
            <a class="p-4 rounded-lg text-xl bg-warning text-gray-900 hover:bg-yellow-400 cursor-pointer">Q&A</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal space-x-4">
                <li class="btn btn-outline btn-primary"><Link href="/">Home</Link></li>
                <li class="btn btn-outline btn-primary"><Link href="/quiz">Quiz </Link></li>
                <li class="btn btn-outline btn-primary"><Link href="/question">Question</Link></li>
                
            </ul>
        </div>
    </div>
</template>
