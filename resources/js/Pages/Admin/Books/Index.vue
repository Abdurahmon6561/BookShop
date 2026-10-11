<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Manage Books
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
          <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">
              Books
            </h2>
          </div>
          <div class="mt-4 flex items-center sm:mt-0 sm:ml-3">
            <Link :href="route('admin.books.create')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              New Book
            </Link>
          </div>
        </div>

        <!-- Flash messages -->
        <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
          {{ $page.props.flash.success }}
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium text-gray-900">Books List</h3>
            <p class="mt-1 text-sm text-gray-600">
              Manage your book inventory.
            </p>
          </div>
          <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Cover
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Title
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Author
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Price
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Stock
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="book in books.data" :key="book.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img
                          :src="`/storage/${book.image}`"
                          :alt="book.title"
                          class="h-10 w-10 rounded object-cover"
                          v-if="book.image"
                        >
                        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500"
                          v-else
                        >
                          No Image
                        </div>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ book.title }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ book.title }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ book.author || 'N/A' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${{ book.price }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ book.stock_quantity }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <Link
                      :href="route('admin.books.edit', book.id)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Edit
                    </Link>
                    <button
                      @click="deleteBook(book.id)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
          <p class="text-sm text-gray-500">
            Showing
            <span class="font-medium">{{ books.from }}</span>
            to
            <span class="font-medium">{{ books.to }}</span>
            of
            <span class="font-medium">{{ books.total }}</span>
            results
          </p>
          <div class="flex items-center space-x-2">
            <Link
              v-if="books.prev_page_url"
              :href="books.prev_page_url"
              class="px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link
              v-if="books.next_page_url"
              :href="books.next_page_url"
              class="px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();
const books = page.props.books;

const deleteBook = (id) => {
  if (window.confirm('Are you sure you want to delete this book?')) {
    router.delete(route('admin.books.destroy', id));
  }
};
</script>