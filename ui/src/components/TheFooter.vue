<template lang="pug">
  footer
    .copy 
      | Combining technologies is fun! Contribute to this project on
      |
      a(:href='githubUrl', target='_blank') GitHub
      | .
</template>

<script>
export default {
  name: 'the-footer',
  computed: {
    githubUrl: () => 'https://github.com/jozsefsallai/phue'
  }
};
</script>

<style lang="scss">
  footer {
    text-align: center;
    font-size: 14px;
    color: #888;
    padding: 10px;
  }
</style>
