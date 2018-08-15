<template lang="pug">
  app-template
    h2.title PHP Vue Single Page Application Demo
    p
      | This is a simple demo for a single page application that uses
      | PHP for the API backend and Vue for the frontend. The demo also
      | includes a router that is very similar to what you would normally
      | see in Express.js, hence making it easier for JavaScript developers
      | to create modern apps with the ways they are used to.
    p
      | This example app is a simple task manager web app that allows
      | you to create tasks, edit them, and mark them as resolved.
</template>

<script>
import AppTemplate from 'components/AppTemplate';

export default {
  name: 'about-page',
  components: {
    'app-template': AppTemplate
  }
};
</script>
