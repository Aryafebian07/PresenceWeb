<template>
    <div>
        <Head :title="form.nama" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/mahasiswas">Mahasiswa</Link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.nama }}
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <text-input v-model="form.nim" :error="form.errors.nim" class="pb-8 pr-6 w-full lg:w-1/2" label="NIM" />
                    <text-input v-model="form.nama" :error="form.errors.nama" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama" />
                    <select-input v-model="form.prodi_id" :options="prodiOptions" :error="form.errors.prodi_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Program Studi" required>
                        <option v-for="option in prodiOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select-input>
                    <select-input v-model="form.angkatan" :options="angkatanOptions" :error="form.errors.angkatan" class="pb-8 pr-6 w-full lg:w-1/2" label="Angkatan" required>
                        <option v-for="option in angkatanOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select-input>
                    <select-input v-model="form.sistem_kuliah" :error="form.errors.sistem_kuliah" class="pb-8 pr-6 w-full lg:w-1/2" label="Sistem Kuliah">
                        <option :value="'0'">Reguler</option>
                        <option :value="'1'">Non Reguler</option>
                    </select-input>
                    <select-input v-model="form.kelase_id" :options="kelaseOptions" :error="form.errors.kelase_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Kelas" required>
                        <option v-for="option in kelaseOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select-input>
                    <select-input v-model="form.gender" :error="form.errors.gender" class="pb-8 pr-6 w-full lg:w-1/2" label="Jenis Kelamin" required>
                        <option :value="'L'">Laki-laki</option>
                        <option :value="'P'">Perempuan</option>
                    </select-input>
                    <text-input v-model="form.agama" :error="form.errors.agama" class="pb-8 pr-6 w-full lg:w-1/2" label="Agama" />
                    <text-input v-model="form.tempat_lahir" :error="form.errors.tempat_lahir" class="pb-8 pr-6 w-full lg:w-1/2" label="Tempat Lahir" />
                    <date-input v-model="form.tanggal_lahir" :error="form.errors.tanggal_lahir" class="pb-8 pr-6 w-full lg:w-1/2" label="Tanggal Lahir" />
                    <text-input v-model="form.berat_badan" :error="form.errors.berat_badan" class="pb-8 pr-6 w-full lg:w-1/2" label="Berat Badan" />
                    <text-input v-model="form.tinggi_badan" :error="form.errors.tinggi_badan" class="pb-8 pr-6 w-full lg:w-1/2" label="Tinggi Badan" />
                    <select-input v-model="form.golongan_darah" :error="form.errors.golongan_darah" class="pb-8 pr-6 w-full lg:w-1/2" label="Golongan Darah" required>
                        <option :value="'-'">-</option>
                        <option :value="'A'">A</option>
                        <option :value="'B'">B</option>
                        <option :value="'O'">O</option>
                        <option :value="'AB'">AB</option>
                    </select-input>
                    <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2" label="Status Mahasiswa">
                        <option :value="'0'">Aktif</option>
                        <option :value="'1'">Tidak Aktif</option>
                    </select-input>
                    <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
                    <text-input v-model="form.notelp" :error="form.errors.notelp" class="pb-8 pr-6 w-full lg:w-1/2" label="No Telp" />
                    <text-input v-model="form.nohp" :error="form.errors.nohp" class="pb-8 pr-6 w-full lg:w-1/2" label="No Hp" />
                    <textarea-input v-model="form.alamat" :error="form.errors.alamat" class="pb-8 pr-6 w-full lg:w-1/2" label="Alamat" />
                </div>
                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button v-if="!mahasiswa.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus</button>
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
            //   TrashedMessage,
        },
        layout: Layout,
        props: {
            mahasiswa: Object,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    id: this.mahasiswa.id,
                    nim: this.mahasiswa.nim,
                    nama: this.mahasiswa.nama,
                    email: this.mahasiswa.email,
                    gender: this.mahasiswa.gender,
                    angkatan:this.mahasiswa.angkatan,
                    sistem_kuliah: this.mahasiswa.sistem_kuliah,
                    tempat_lahir: this.mahasiswa.tempat_lahir,
                    tanggal_lahir: this.mahasiswa.tanggal_lahir,
                    berat_badan: this.mahasiswa.berat_badan,
                    tinggi_badan: this.mahasiswa.tinggi_badan,
                    agama: this.mahasiswa.agama,
                    golongan_darah: this.mahasiswa.golongan_darah,
                    nohp: this.mahasiswa.nohp,
                    notelp: this.mahasiswa.notelp,
                    alamat: this.mahasiswa.alamat,
                    status: this.mahasiswa.status,
                    prodi_id: this.mahasiswa.prodi_id,
                    kelase_id: this.mahasiswa.kelase_id,
                }),
                prodiOptions:[],
                angkatanOptions:[],
                kelaseOptions:[],
            }
        },
        methods: {
            update() {
                this.form.put(`/mahasiswas/${this.mahasiswa.id}`)
            },
            destroy() {
                if (confirm('Are you sure you want to delete this Mahasiswa?')) {
                    this.$inertia.delete(`/mahasiswas/${this.mahasiswa.id}`)
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this Mahasiswa?')) {
                    this.$inertia.put(`/mahasiswas/${this.mahasiswa.id}/restore`)
                }
            },
            fetchProdiOptions() {
                this.prodiOptions = this.$page.props.prodiOptions;
            },
            fetchAngkatanOptions() {
                const selectedProdiId = this.form.prodi_id
                this.angkatanOptions = this.$page.props.angkatanOptions.filter(option => option.prodi_id === selectedProdiId)
            },
            fetchKelaseOptions() {
                const selectedangkatan = this.form.angkatan
                this.kelaseOptions = this.$page.props.kelaseOptions.filter(option => option.angkatan === selectedangkatan)
            },
        },
        mounted() {
            this.fetchProdiOptions()
        },
        watch: {
            'form.prodi_id': {
                immediate: true,
                handler(newVal) {
                    this.fetchAngkatanOptions()
                },
            },
            'form.angkatan': {
                immediate: true,
                handler(newVal) {
                    this.fetchKelaseOptions()
                },
            },
        },
    }
</script>
