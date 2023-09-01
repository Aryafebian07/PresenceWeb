<template>
    <div>
        <Head title="Tambah Kelas" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/kelases">Kelas</Link>
            <span class="text-indigo-400 font-medium">/</span> Tambah
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <select-input v-model="form.prodi_id" :options="prodiOptions" :error="form.errors.prodi_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Program Studi" required>
                <option v-for="option in prodiOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
            <select-input v-model="form.angkatan" :options="angkatanOptions" :error="form.errors.angkatan" class="pb-8 pr-6 w-full lg:w-1/2" label="Angkatan" required>
                <option v-for="option in angkatanOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
            <text-input v-model="form.nama" :error="form.errors.nama" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama" />
            <select-input v-model="form.dosen_id" :options="dosenOptions" :error="form.errors.dosen_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Dosen" required>
                <option v-for="option in dosenOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
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
                nama: null,
                angkatan: null,
                prodi_id: null,
                dosen_id: null,
            }),
            prodiOptions:[],
            angkatanOptions:[],
            dosenOptions:[],
        }
    },
    methods: {
        store() {
            this.form.post('/kelases')
        },
        fetchProdiOptions() {
            this.prodiOptions = this.$page.props.prodiOptions;
        },
        fetchAngkatanOptions() {
            this.angkatanOptions = this.$page.props.angkatanOptions;
        },
        fetchDosenOptions() {
            const selectedProdiId = this.form.prodi_id
            this.dosenOptions = this.$page.props.dosenOptions.filter(option => option.prodi_id === selectedProdiId)
        },
    },
    mounted() {
        this.fetchProdiOptions()
        this.fetchAngkatanOptions()
    },
    watch: {
        'form.prodi_id': {
            immediate: true,
            handler(newVal) {
                this.fetchDosenOptions();
            },
        },
    },
}
</script>
