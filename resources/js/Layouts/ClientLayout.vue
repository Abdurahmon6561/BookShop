<template>
  <div class="min-h-screen bg-slate-950 font-sans antialiased text-slate-100">
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 backdrop-blur-xl bg-slate-950/80 border-b border-slate-800/80 shadow-2xl">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
          <!-- Logo -->
          <div class="flex items-center space-x-12">
            <Link :href="route('books.index')" class="flex items-center space-x-3 group">
              <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-violet-600/30 group-hover:scale-105 transition-transform duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
              </div>
              <span class="text-xl font-black tracking-tight text-white group-hover:text-violet-400 transition-colors">BookShop</span>
            </Link>

            <div class="hidden md:flex items-center space-x-8">
              <Link :href="route('books.index')" class="text-sm font-semibold text-violet-400 transition-colors">
                Store Catalog
              </Link>
            </div>
          </div>

          <!-- User / Auth Links -->
          <div class="flex items-center space-x-4">
            <template v-if="$page.props.auth.user">
              <Link
                v-if="$page.props.auth.user.is_admin"
                :href="route('admin.dashboard')"
                class="px-4 py-2 rounded-xl bg-violet-600 hover:bg-violet-500 text-white font-semibold text-xs shadow-lg shadow-violet-600/30 transition-all duration-200"
              >
                Admin Dashboard
              </Link>
              <div class="flex items-center space-x-3 pl-2 border-l border-slate-800">
                <span class="text-sm font-medium text-slate-300">{{ $page.props.auth.user.name }}</span>
                <Link
                  :href="route('logout')"
                  method="post"
                  as="button"
                  class="text-xs font-semibold text-slate-400 hover:text-rose-400 transition-colors px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800"
                >
                  Log Out
                </Link>
              </div>
            </template>
            <template v-else>
              <Link
                :href="route('login')"
                class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 font-semibold text-xs border border-slate-800 transition-all"
              >
                Sign In
              </Link>
              <Link
                :href="route('register')"
                class="px-4 py-2 rounded-xl bg-violet-600 hover:bg-violet-500 text-white font-semibold text-xs shadow-lg shadow-violet-600/30 transition-all"
              >
                Create Account
              </Link>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950 py-12 px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center space-x-2">
          <div class="w-6 h-6 rounded-lg bg-violet-600 flex items-center justify-center text-white text-xs font-bold">B</div>
          <span class="font-bold text-slate-300">BookShop &copy; 2026</span>
        </div>
        <p>Curated literary masterpieces & bestseller insights. All rights reserved.</p>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
