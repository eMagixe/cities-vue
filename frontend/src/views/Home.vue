<template>
  <div class="container" >
    <div class="d-flex align-items-center" v-if="load">
      <strong>Загрузка...</strong>
      <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
    </div>
    <div class="row" v-else-if="!load">
      <div class="col-sm">
        <div class="input-group flex-nowrap">
          <div class="input-group-prepend">
            <span class="input-group-text" id="addon-wrapping">Поиск</span>
          </div>
          <input @change.passive="search" list="citiesResult" type="text" class="form-control" aria-label="Search" aria-describedby="addon-wrapping">
        </div>
        <datalist id="citiesResult">
          <option :value="city.name" v-for="city in results" :key="city.id" />
        </datalist>
        <div v-for="city in results" :key="city.id" class="card mt-2">
          <div class="card-body">
            <h5 class="card-title">Country: {{ city.country }}</h5>
            <p class="card-text">{{ city.id }} - {{ city.name }}.</p>
            <router-link :to="'/about/' + city.id" class="btn btn-primary">Подробнее</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Home',
  data() {
    return {
      results: []
    }
  },
  methods: {
    ...mapActions([
      'getData'
    ]),
    search($event) {
      this.results = [];

      for(let city of this.cities) {
        if(this.results.length === 10) break;
        if(city.name.indexOf($event.target.value) != -1) this.results.push(city);
      }
    }
  },
  created() {
    this.getData();
  },
  computed: {
    ...mapGetters([
      'cities',
      'load'
    ])
  }
}
</script>
