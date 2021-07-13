<template>
  <v-app>
    <v-main>
      <Form/>
    </v-main>
  </v-app>
</template>

<script>
import Form from './components/Form';
export default {
  name: 'App',

  components: {
    Form,
  },

  data: () => ({
    //
  }),
};
</script>
<style>
  body{
    margin: 55px auto;
    max-width: 550px;
  }
</style>
