<template>
  <div class="about container">
    <div class="card">
      <h4 class="card-header">Название: {{ currentCity.name }}</h4>
      <div class="card-body">
        <h5 class="card-title">Код: {{ currentCity.country }}</h5>
        <h5>Координаты:</h5>
        <p class="card-text">Широта: {{ currentCity.lat }}. Долгота: {{ currentCity.lng }}</p>
        <div>ID: {{ currentCity.id }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: "About",
  methods: {
    ...mapActions([
      'getCity'
    ])
  },
  created() {
    this.getCity(this.$route.params.id);
  },
  computed: {
    ...mapGetters([
      'currentCity'
    ])
  }
}
</script>