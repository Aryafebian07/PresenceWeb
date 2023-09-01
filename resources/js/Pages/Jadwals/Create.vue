<template>
    <div>
        <Head title="Tambah Jadwal" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/jadwals">Jadwal</Link>
            <span class="text-indigo-400 font-medium">/</span> Tambah
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <select-input v-model="form.prodi_id" :options="prodiOptions" :error="form.errors.prodi_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Program Studi" required>
                <option v-for="option in prodiOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
            <select-input v-model="form.matkul_id" :options="matkulOptions" :error="form.errors.matkul_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Mata Kuliah" required>
                <option v-for="option in matkulOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
            <select-input v-model="form.kelase_id" :options="kelaseOptions" :error="form.errors.kelase_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Kelas" required>
                <option v-for="option in kelaseOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
            <select-input v-model="form.dosen_id" :options="dosenOptions" :error="form.errors.dosen_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Dosen Pengajar" required>
                <option v-for="option in dosenOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
            <select-input v-model="form.tahun_ajar" :options="tahunOptions" :error="form.errors.tahun_ajar" class="pb-8 pr-6 w-full lg:w-1/2" label="Tahun Ajar" required>
                <option v-for="option in tahunOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select-input>
            <text-input v-model="form.semester" :error="form.errors.semester" class="pb-8 pr-6 w-full lg:w-1/2" label="Semester" />
            <time-input v-model="form.jam_mulai" :error="form.errors.jam_mulai" class="pb-8 pr-6 w-full lg:w-1/2" label="Jam Mulai" />
            <time-input v-model="form.jam_selesai" :error="form.errors.jam_selesai" class="pb-8 pr-6 w-full lg:w-1/2" label="Jam Selesai" />
            <select-input v-model="form.hari" :error="form.errors.hari" class="pb-8 pr-6 w-full lg:w-1/2" label="Hari" required>
                <option :value="'Senin'">Senin</option>
                <option :value="'Selasa'">Selasa</option>
                <option :value="'Rabu'">Rabu</option>
                <option :value="'Kamis'">Kamis</option>
                <option :value="'Jumat'">Jumat</option>
                <option :value="'Sabtu'">Sabtu</option>
                <option :value="'Minggu'">Minggu</option>
            </select-input>
            <text-input v-model="form.total_pertemuan" :error="form.errors.total_pertemuan" class="pb-8 pr-6 w-full lg:w-1/2" label="Total Pertemuan" />
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
import TimeInput from '@/Components/TimeInput.vue'
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
        TimeInput,
        TextareaInput,
    },
    layout: Layout,
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                tahun_ajar: null,
                semester: null,
                hari: null,
                jam_mulai: null,
                jam_selesai: null,
                total_pertemuan: null,
                kelase_id: null,
                dosen_id: null,
                matkul_id: null,
            }),
            prodiOptions:[],
            matkulOptions:[],
            kelaseOptions:[],
            dosenOptions:[],
            tahunOptions:[],
        }
    },
    methods: {
        store() {
            this.form.post('/jadwals')
        },
        fetchProdiOptions() {
            this.prodiOptions = this.$page.props.prodiOptions;
        },
        fetchKelaseOptions() {
            const selectedProdiId = this.form.prodi_id
            this.kelaseOptions = this.$page.props.kelaseOptions.filter(option => option.prodi_id === selectedProdiId)
        },
        fetchMatkulOptions() {
            const selectedProdiId = this.form.prodi_id
            this.matkulOptions = this.$page.props.matkulOptions.filter(option => option.prodi_id === selectedProdiId)
        },
        fetchDosenOptions() {
            this.dosenOptions = this.$page.props.dosenOptions;
        },
        fetchTahunOptions() {
            this.tahunOptions = this.$page.props.tahunOptions;
        },
    },
    mounted() {
        this.fetchProdiOptions()
        this.fetchDosenOptions()
        this.fetchTahunOptions()
    },
    watch: {
        'form.prodi_id': {
            immediate: true,
            handler(newVal) {
                this.fetchKelaseOptions()
                this.fetchMatkulOptions()
            },
        },
    },
}
</script>
