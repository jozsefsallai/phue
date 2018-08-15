<template lang="pug">
  .app
    header
      .logo
        router-link(to='/') PHP Vue SPA
      nav.navigation
        router-link(to='/') Home
        router-link(to='/about') About
    .container
      slot
    the-footer
</template>

<script>
import TheFooter from 'components/TheFooter';

export default {
  name: 'app-template',
  components: {
    'the-footer': TheFooter
  }
};
</script>

<style lang="scss">
  @import 'src/styles/colors';

  header {
    background: $theme;
    display: flex;
    align-items: center;
    justify-content: space-between;

    .logo {
      a {
        display: inline-block;
        color: #fff;
        font-weight: 700;
        font-size: 24px;
        padding: 10px 25px;
      }
    }

    .navigation {
      padding: 0 20px;

      a {
        display: inline-block;
        color: #fff;
        padding: 5px 25px;
        margin-right: 5px;

        &:last-child {
          margin-right: 0;
        }

        &.router-link-exact-active, &:hover {
          background: rgba(0, 0, 0, 0.2);
        }
      }
    }
  }
</style>
