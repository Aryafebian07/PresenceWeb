<template>
    <div>
        <Head title="Kelas" />
        <h1 class="mb-8 text-3xl font-bold">Kelas</h1>
        <div class="flex items-center justify-between mb-6">
            <Link class="btn-indigo" href="/kelases/create">
                <span>Tambah</span>
                <span class="hidden md:inline">&nbsp;Kelas</span>
            </Link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6">Nama</th>
                        <th class="pb-4 pt-6 px-6">Angkatan</th>
                        <th class="pb-4 pt-6 px-6">Program Studi</th>
                        <th class="pb-4 pt-6 px-6">Wali Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="kelas in kelases.data" :key="kelas.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/kelases/${kelas.id}/edit`">
                                {{ kelas.nama }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/kelases/${kelas.id}/edit`">
                                {{ kelas.angkatan }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/kelases/${kelas.id}/edit`" tabindex="-1">
                                {{ kelas.prodi }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/kelases/${kelas.id}/edit`">
                                {{ kelas.dosen }}
                            </Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4" :href="`/kelases/${kelas.id}/edit`" tabindex="-1">
                                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="kelases.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">Tidak ada Kelas ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="kelases.links" />
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
            kelases : Object,
        },
        watch: {
            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get('/kelases', pickBy(this.form), { preserveState: true })
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
