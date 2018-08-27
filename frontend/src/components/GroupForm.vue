<template>
  <div
    class="d-flex w-50 mx-auto"
    style="max-width: 350px;"
  >
    <input
      v-model="form.name"
      type="text"
      class="form-control form-control-sm"
      placeholder="List name"
    >
    <button
      role="button"
      class="btn btn-primary btn-dark btn-sm ml-2"
      @click="addGroup"
    >
      <!--➕-->
      <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABaUlEQVQ4T2NkoBAw4tIfujt0PwMDgwNU/sBq19WO2NTiNCBoR9B/MzMzsJ5Tp04xrPNYh1UtTgP8tvj9Nzc3Bxtw8uRJhk0+m0gzwHO9538LCwuwASdOnGDYHridNAOcVzr/t7S0BBtw/Phxhr3he3EbYLvYdj8zM7MDGxsbAwizsrKCsaKiItiA+/fvM/z+/RuMf/36BcZ///49cDj2sCPYVLM5Zv+DgoJQAvnr168MX758AYvx8PAwcHNzo8ivW7eO4VTKKUawAQbTDP7b2NiQlCKOHDnCcCHrAsQAzX7N/SwsLA4gZ4O8wM7ODvaCkpIS2NB79+6Bnf/z50+w80HsP3/+HLheeB3iBWxAuVP5v52dHVjq0KFDDHfL75IWC7LNsv/t7e3BBhw8eJDhce1j0gyQqJP47+AASckHDhxgeNH0gjQDRKpE/js6QpL//v37Gd60vSHNAMFyQZTM9L7zPWmZidg4BQC6j4QRBvLeBAAAAABJRU5ErkJggg==">
      Add
    </button>
  </div>
</template>

<script>
export default {
  name: 'GroupForm',
  data: () => ({
    form: {
      name: null
    }
  }),
  methods: {
    async addGroup () {
      this.$emit('groupCreated', await this.$post('groups/', this.form))
      this.form.name = null
    }
  }
}
</script>
