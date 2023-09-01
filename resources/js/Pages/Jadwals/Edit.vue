<template>
    <div>
        <Head :title="form.nama" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/jadwals">Jadwal</Link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.nama }}
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
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
                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button v-if="!jadwal.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus</button>
                    <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { Head, Link } from '@inertiajs/vue3'
    import Icon from '@/Components/Icon.vue'
    import Layout from '@/Layouts/AppLayout.vue'
    import TextInput from '@/Components/TextInput2.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import LoadingButton from '@/Components/LoadingButton.vue'
    import DateInput from '@/Components/DateInput.vue'
    import TextareaInput from '@/Components/TextareaInput.vue'
    import TimeInput from '@/Components/TimeInput.vue'

    //   import TrashedMessage from '@/Components/TrashedMessage.vue'

    export default {
        components: {
            Head,
            Icon,
            Link,
            LoadingButton,
            SelectInput,
            TextInput,
            DateInput,
            TextareaInput,
            TimeInput,
            //   TrashedMessage,
        },
        layout: Layout,
        props: {
            jadwal: Object,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    id: this.jadwal.id,
                    tahun_ajar: this.jadwal.tahun_ajar,
                    semester: this.jadwal.semester,
                    hari: this.jadwal.hari,
                    jam_mulai: this.jadwal.jam_mulai,
                    jam_selesai: this.jadwal.jam_selesai,
                    total_pertemuan: this.jadwal.total_pertemuan,
                    kelase_id: this.jadwal.kelase_id,
                    dosen_id: this.jadwal.dosen_id,
                    matkul_id: this.jadwal.matkul_id,
                    prodi_id: this.jadwal.prodi_id,
                }),
                prodiOptions:[],
                matkulOptions:[],
                kelaseOptions:[],
                dosenOptions:[],
                tahunOptions:[],
            }
        },
        methods: {
            update() {
                this.form.put(`/jadwals/${this.jadwal.id}`)
            },
            destroy() {
                if (confirm('Are you sure you want to delete this Jadwal?')) {
                    this.$inertia.delete(`/jadwals/${this.jadwal.id}`)
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this Jadwal?')) {
                    this.$inertia.put(`/jadwals/${this.jadwal.id}/restore`)
                }
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
