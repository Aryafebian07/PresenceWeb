<template>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Jumlah Mahasiswa</h5>
        <p class="card-text">{{ jumlahMahasiswa }}</p>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        jumlahMahasiswa: 0,
      };
    },
    mounted() {
      this.fetchJumlahMahasiswa();
    },
    methods: {
      fetchJumlahMahasiswa() {
        // Panggil API endpoint untuk mendapatkan jumlah mahasiswa
        axios.get('/api/dashboard/jumlah-mahasiswa')
          .then(response => {
            this.jumlahMahasiswa = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };
  </script>
