<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold tracking-tight text-slate-800">
          Executive Analytics Dashboard
        </h2>
        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
          Live Store Metrics
        </span>
      </div>
    </template>

    <div class="py-8 bg-slate-50 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Key Metrics Cards -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
          <!-- Total Books -->
          <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100 transition hover:shadow-md">
            <dt class="flex items-center justify-between">
              <span class="text-sm font-medium text-slate-500">Total Books</span>
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
              </div>
            </dt>
            <dd class="mt-4 flex items-baseline justify-between">
              <span class="text-3xl font-extrabold text-slate-900">{{ totalBooks }}</span>
              <span class="text-xs font-medium text-emerald-600">{{ activeBooks }} active</span>
            </dd>
          </div>

          <!-- Most Searched Book -->
          <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500/10 via-amber-500/5 to-white p-6 shadow-sm ring-1 ring-amber-500/20 transition hover:shadow-md">
            <dt class="flex items-center justify-between">
              <span class="text-sm font-medium text-amber-800">Most Searched Book</span>
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-white shadow-sm">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </dt>
            <dd class="mt-4">
              <p class="text-lg font-bold text-slate-900 truncate" :title="mostSearched?.title || 'No data yet'">
                {{ mostSearched ? mostSearched.title : 'No searches yet' }}
              </p>
              <p class="text-xs font-semibold text-amber-600 mt-1">
                {{ mostSearched ? `${mostSearched.search_count} searches` : '0 queries' }}
              </p>
            </dd>
          </div>

          <!-- Most Selling Book -->
          <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500/10 via-emerald-500/5 to-white p-6 shadow-sm ring-1 ring-emerald-500/20 transition hover:shadow-md">
            <dt class="flex items-center justify-between">
              <span class="text-sm font-medium text-emerald-800">Best Seller Book</span>
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
              </div>
            </dt>
            <dd class="mt-4">
              <p class="text-lg font-bold text-slate-900 truncate" :title="mostSold?.title || 'No sales yet'">
                {{ mostSold ? mostSold.title : 'No sales yet' }}
              </p>
              <p class="text-xs font-semibold text-emerald-600 mt-1">
                {{ mostSold ? `${mostSold.purchase_count} units sold` : '0 sales' }}
              </p>
            </dd>
          </div>

          <!-- Most Viewed -->
          <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100 transition hover:shadow-md">
            <dt class="flex items-center justify-between">
              <span class="text-sm font-medium text-slate-500">Most Viewed</span>
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
            </dt>
            <dd class="mt-4">
              <p class="text-lg font-bold text-slate-900 truncate" :title="mostViewed?.title || 'None'">
                {{ mostViewed ? mostViewed.title : 'No views yet' }}
              </p>
              <p class="text-xs font-semibold text-blue-600 mt-1">
                {{ mostViewed ? `${mostViewed.view_count} page visits` : '0 visits' }}
              </p>
            </dd>
          </div>
        </div>

        <!-- Leaderboards Grid: Top Searched vs Top Sold -->
        <div class="grid gap-6 lg:grid-cols-2">
          <!-- Top Searched Books Table -->
          <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
              <div class="flex items-center space-x-2">
                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                <h3 class="text-base font-bold text-slate-900">Highest Search Interest</h3>
              </div>
              <span class="text-xs text-slate-400">Demand Discovery</span>
            </div>
            <div class="mt-4 divide-y divide-slate-100">
              <div v-if="topSearchedBooks.length === 0" class="py-6 text-center text-sm text-slate-400">
                No search analytics recorded yet.
              </div>
              <div v-for="(item, idx) in topSearchedBooks" :key="item.id" class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-3 truncate">
                  <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                    #{{ idx + 1 }}
                  </span>
                  <div class="truncate">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ item.title }}</p>
                    <p class="text-xs text-slate-400">{{ item.author || 'Unknown' }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700">
                    {{ item.search_count }} searches
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Top Sold Books Table -->
          <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
              <div class="flex items-center space-x-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <h3 class="text-base font-bold text-slate-900">Top Performing Sellers</h3>
              </div>
              <span class="text-xs text-slate-400">Revenue Drivers</span>
            </div>
            <div class="mt-4 divide-y divide-slate-100">
              <div v-if="topSoldBooks.length === 0" class="py-6 text-center text-sm text-slate-400">
                No book sales recorded yet.
              </div>
              <div v-for="(item, idx) in topSoldBooks" :key="item.id" class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-3 truncate">
                  <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                    #{{ idx + 1 }}
                  </span>
                  <div class="truncate">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ item.title }}</p>
                    <p class="text-xs text-slate-400">${{ item.price }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">
                    {{ item.purchase_count }} sold
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Inventory Health / Low Stock Warning -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
          <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
              <h3 class="text-base font-bold text-slate-900">Inventory Status & Alerts</h3>
              <p class="text-xs text-slate-500 mt-0.5">Books with less than 10 units in stock</p>
            </div>
            <Link :href="route('admin.books.index')" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
              Manage Inventory &rarr;
            </Link>
          </div>
          <div class="mt-4">
            <div v-if="lowStock.length === 0" class="py-8 text-center text-sm text-emerald-600 font-medium">
              All inventory levels are healthy! No books currently low on stock.
            </div>
            <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
              <div v-for="book in lowStock" :key="book.id" class="flex items-center justify-between p-3 rounded-xl bg-rose-50/50 border border-rose-100">
                <div class="truncate pr-2">
                  <p class="text-sm font-semibold text-slate-800 truncate">{{ book.title }}</p>
                  <p class="text-xs text-rose-600 font-medium">Only {{ book.stock_quantity }} left</p>
                </div>
                <Link :href="route('admin.books.edit', book.id)" class="text-xs font-semibold text-indigo-600 hover:underline">
                  Restock
                </Link>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const {
  totalBooks = 0,
  activeBooks = 0,
  mostViewed = null,
  mostSearched = null,
  mostSold = null,
  topSearchedBooks = [],
  topSoldBooks = [],
  lowStock = [],
} = page.props;
</script>