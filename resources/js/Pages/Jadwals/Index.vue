<template>
    <div>
        <Head title="Jadwal" />
        <h1 class="mb-8 text-3xl font-bold">Jadwal</h1>
        <div class="flex items-center justify-between mb-6">
            <Link class="btn-indigo" href="/jadwals/create">
                <span>Tambah</span>
                <span class="hidden md:inline">&nbsp;Jadwal</span>
            </Link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6">Kode</th>
                        <th class="pb-4 pt-6 px-6">Mata Kuliah</th>
                        <th class="pb-4 pt-6 px-6">Kelas</th>
                        <th class="pb-4 pt-6 px-6">Jadwal</th>
                        <th class="pb-4 pt-6 px-6">Dosen Pengajar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="jadwal in jadwals.data" :key="jadwal.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/jadwals/${jadwal.id}/edit`">
                                {{ jadwal.kode }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/jadwals/${jadwal.id}/edit`">
                                {{ jadwal.nama }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/jadwals/${jadwal.id}/edit`" tabindex="-1">
                                {{ jadwal.kelase }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/jadwals/${jadwal.id}/edit`" tabindex="-1">
                                {{ jadwal.hari }},{{ jadwal.jam_mulai }} s.d {{ jadwal.jam_selesai }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/jadwals/${jadwal.id}/edit`">
                                {{ jadwal.dosen }}
                            </Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4" :href="`/jadwals/${jadwal.id}/edit`" tabindex="-1">
                                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="jadwals.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">Tidak ada Jadwal ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="jadwals.links" />
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
            jadwals : Object,
        },
        watch: {
            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get('/jadwals', pickBy(this.form), { preserveState: true })
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
