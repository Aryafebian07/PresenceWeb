<template>
    <div>
        <Head title="Tambah Program Studi" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/prodis">Program Studi</Link>
            <span class="text-indigo-400 font-medium">/</span> Tambah
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                <text-input v-model="form.kode" :error="form.errors.kode" class="pb-8 pr-6 w-full lg:w-1/2" label="Kode" />
                <text-input v-model="form.nama" :error="form.errors.nama" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama" />
                <select-input v-model="form.jenjang" :error="form.errors.jenjang" class="pb-8 pr-6 w-full lg:w-1/2" label="Jenjang">
                    <option :value="'-'">-</option>
                    <option :value="'D1'">D1</option>
                    <option :value="'D2'">D2</option>
                    <option :value="'D3'">D3</option>
                    <option :value="'D4'">D4</option>
                    <option :value="'S1'">S1</option>
                    <option :value="'S2'">S2</option>
                    <option :value="'S3'">S3</option>
                    <option :value="'Profesi'">Profesi</option>
                    <option :value="'Spesialis'">Spesialis</option>
                </select-input>
                <select-input v-model="form.akreditasi" :error="form.errors.akreditasi" class="pb-8 pr-6 w-full lg:w-1/2" label="Akreditasi">
                    <option :value="'-'">-</option>
                    <option :value="'A'">A</option>
                    <option :value="'B'">B</option>
                    <option :value="'C'">C</option>
                    <option :value="'Unggul'">Unggul</option>
                    <option :value="'Baik Sekali'">Baik Sekali</option>
                    <option :value="'Baik'">Baik</option>
                </select-input>
                <date-input v-model="form.tanggal_berdiri" :error="form.errors.tanggal_berdiri" class="pb-8 pr-6 w-full lg:w-1/2" label="Tanggal Berdiri" />
                <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2" label="Status">
                    <option :value="'0'">Aktif</option>
                    <option :value="'1'">Tidak Aktif</option>
                </select-input>
                <textarea-input v-model="form.visi" :error="form.errors.visi" class="pb-8 pr-6 w-full lg:w-1/2" label="Visi" />
                <textarea-input v-model="form.misi" :error="form.errors.misi" class="pb-8 pr-6 w-full lg:w-1/2" label="Misi" />
                <textarea-input v-model="form.deskripsi" :error="form.errors.deskripsi" class="pb-8 pr-6 w-full lg:w-1/2" label="Deskripsi" />
                <textarea-input v-model="form.kompetensi" :error="form.errors.kompetensi" class="pb-8 pr-6 w-full lg:w-1/2" label="Kompetensi" />

                </div>
                <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                <loading-button :loading="form.processing" class="btn-indigo" type="submit">Simpan</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Layouts/AppLayout.vue'
import TextInput from '@/Components/TextInput2.vue'
import TextareaInput from '@/Components/TextareaInput.vue'
import DateInput from '@/Components/DateInput.vue'
import SelectInput from '@/Components/SelectInput.vue'
import LoadingButton from '@/Components/LoadingButton.vue'

export default {
    components: {
        Head,
        Link,
        LoadingButton,
        SelectInput,
        TextInput,
        DateInput,
        TextareaInput,
    },
    layout: Layout,
    remember: 'form',
    data() {
        return {
        form: this.$inertia.form({
            kode: null,
            nama: null,
            jenjang: null,
            akreditasi: null,
            tanggal_berdiri: null,
            status: null,
            visi: null,
            misi: null,
            deskripsi: null,
            kompetensi: null,
        }),
        }
    },
    methods: {
        store() {
        this.form.post('/prodis')
        },
    },
}
</script>
