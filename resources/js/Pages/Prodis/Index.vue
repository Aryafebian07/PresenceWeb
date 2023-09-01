<template>
    <div>
        <Head title="Program Studi" />
        <h1 class="mb-8 text-3xl font-bold">Program Studi</h1>
        <div class="flex items-center justify-between mb-6">
            <Link class="btn-indigo" href="/prodis/create">
                <span>Tambah</span>
                <span class="hidden md:inline">&nbsp;Program Studi</span>
            </Link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6">Kode</th>
                        <th class="pb-4 pt-6 px-6">Nama</th>
                        <th class="pb-4 pt-6 px-6">Status</th>
                        <th class="pb-4 pt-6 px-6">Jenjang</th>
                        <th class="pb-4 pt-6 px-6">Akreditasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="prodi in prodis.data" :key="prodi.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/prodis/${prodi.id}/edit`">
                                {{ prodi.kode }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/prodis/${prodi.id}/edit`" tabindex="-1">
                                {{ prodi.nama }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/prodis/${prodi.id}/edit`" tabindex="-1">
                                <span v-if="prodi.status === 0" style="text-shadow: 1px 1px 2px green;">Aktif</span>
                                <span v-if="prodi.status === 1" style="text-shadow: 1px 1px 2px red;">Tidak Aktif</span>
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/prodis/${prodi.id}/edit`" tabindex="-1">
                                {{ prodi.jenjang }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/prodis/${prodi.id}/edit`" tabindex="-1">
                                {{ prodi.akreditasi }}
                            </Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4" :href="`/prodis/${prodi.id}/edit`" tabindex="-1">
                                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="prodis.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">Tidak ada Program Studi ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="prodis.links" />
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
            prodis : Object,
        },
        watch: {
            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get('/prodis', pickBy(this.form), { preserveState: true })
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
