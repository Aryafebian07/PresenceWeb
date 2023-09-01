<template>
    <div>
      <Head title="Users" />
      <h1 class="mb-8 text-3xl font-bold">Users</h1>
      <div class="flex items-center justify-between mb-6">
        <Link class="btn-indigo" href="/user/create">
          <span>Create</span>
          <span class="hidden md:inline">&nbsp;User</span>
        </Link>
      </div>
      <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">Username</th>
                <th class="pb-4 pt-6 px-6">Name</th>
                <th class="pb-4 pt-6 px-6">Email</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/user/${user.id}/edit`">
                        {{ user.username }}
                    </Link>
                </td>
                <td class="border-t">
                    <Link class="flex items-center px-6 py-4" :href="`/user/${user.id}/edit`" tabindex="-1">
                        {{ user.name }}
                    </Link>
                </td>
                <td class="border-t">
                    <Link class="flex items-center px-6 py-4" :href="`/user/${user.id}/edit`" tabindex="-1">
                        {{ user.email }}
                    </Link>
                </td>
                <td class="w-px border-t">
                    <Link class="flex items-center px-4" :href="`/user/${user.id}/edit`" tabindex="-1">
                        <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                    </Link>
                </td>
            </tr>
            <tr v-if="users.data.length === 0">
              <td class="px-6 py-4 border-t" colspan="4">No Users found.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination class="mt-6" :links="users.links" />
    </div>
  </template>

<script>
    import { Head, Link, usePage } from '@inertiajs/vue3'
    import Icon from '@/Components/Icon.vue'
    import pickBy from 'lodash/pickBy'
    import Layout from '@/Layouts/AppLayout.vue'
    import throttle from 'lodash/throttle'
    import mapValues from 'lodash/mapValues'
    import Pagination from '@/Components/Pagination.vue'
    import SearchFilter from '@/Components/SearchFilter.vue'

    export default{
        components: {
            Head,
            Icon,
            Link,
            Pagination,
            SearchFilter,
        },
        layout: Layout,
        props : {
            users : Object,
        },
        watch: {
            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get('/user', pickBy(this.form), { preserveState: true })
                }, 150),
            },
        },
        methods: {
            reset() {
                this.form = mapValues(this.form, () => null)
            },
        },
    }
</script>
