<template>
    <div>
        <Head title="Mata Kuliah" />
        <h1 class="mb-8 text-3xl font-bold">Mata Kuliah</h1>
        <div class="flex items-center justify-between mb-6">
            <Link class="btn-indigo" href="/matkuls/create">
                <span>Tambah</span>
                <span class="hidden md:inline">&nbsp;Mata Kuliah</span>
            </Link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6">kode</th>
                        <th class="pb-4 pt-6 px-6">Program Studi</th>
                        <th class="pb-4 pt-6 px-6">Nama</th>
                        <th class="pb-4 pt-6 px-6">SKS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="matkul in matkuls.data" :key="matkul.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/matkuls/${matkul.id}/edit`">
                                {{ matkul.kode }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/matkuls/${matkul.id}/edit`">
                                {{ matkul.prodi }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/matkuls/${matkul.id}/edit`" tabindex="-1">
                                {{ matkul.nama }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/matkuls/${matkul.id}/edit`">
                                {{ matkul.sks }}
                            </Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4" :href="`/matkuls/${matkul.id}/edit`" tabindex="-1">
                                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="matkuls.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">Tidak ada Mata Kuliah ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="matkuls.links" />
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
            matkuls : Object,
        },
        watch: {
            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get('/matkuls', pickBy(this.form), { preserveState: true })
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
