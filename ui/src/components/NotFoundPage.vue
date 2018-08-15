<template lang="pug">
  app-template
    h2.title Page Not Found
    p What a bummer... Maybe go back to the <router-link to='/'>home page</router-link>?
</template>

<script>
import AppTemplate from 'components/AppTemplate';

export default {
  name: 'not-found',
  components: {
    'app-template': AppTemplate
  }
};
</script>
