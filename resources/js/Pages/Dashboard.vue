<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Mahasiswa -->
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <h5 class="font-bold text-lg mb-2">Jumlah Mahasiswa</h5>
                        <p class="text-xl">{{ jumlahMahasiswa }}</p>
                    </div>

                    <!-- Dosen -->
                    <div class="bg-green-100 border border-green-400 text-green-700 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <h5 class="font-bold text-lg mb-2">Jumlah Dosen</h5>
                        <p class="text-xl">{{ jumlahDosen }}</p>
                    </div>

                    <!-- Prodi -->
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <h5 class="font-bold text-lg mb-2">Jumlah Prodi</h5>
                        <p class="text-xl">{{ jumlahProdi }}</p>
                    </div>

                    <!-- Matakuliah -->
                    <div class="bg-purple-100 border border-purple-400 text-purple-700 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <h5 class="font-bold text-lg mb-2">Jumlah Matakuliah</h5>
                        <p class="text-xl">{{ jumlahMatakuliah }}</p>
                    </div>

                    <!-- Kelas -->
                    <div class="bg-pink-100 border border-pink-400 text-pink-700 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <h5 class="font-bold text-lg mb-2">Jumlah Kelas</h5>
                        <p class="text-xl">{{ jumlahKelas }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps } from 'vue';

const props = defineProps({
    jumlahMahasiswa: Number,
    jumlahDosen: Number,
    jumlahProdi: Number,
    jumlahMatakuliah: Number,
    jumlahKelas: Number,
});

</script>
