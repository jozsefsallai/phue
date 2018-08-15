<template lang="pug">
  .create-task-form
    form(@submit='handleSubmit')
      input(name='name', placeholder='Task name', autocomplete='off')
      button(type='submit') Add
    .alert.error(v-if='error') {{ error }}
</template>

<script>
import axios from 'axios';

export default {
  name: 'create-task',
  data: function () {
    return {
      error: null
    };
  },
  methods: {
    handleSubmit: function (e) {
      e.preventDefault();
      const name = e.target.name.value;
      const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      };

      axios.post('/api/tasks', {
        name
      }, { credentials: 'same-origin', headers })
        .then(({ data }) => {
          if (data.ok) {
            this.$store.commit('createTask', data.record);
            this.$emit('taskCreated');
          } else if (data.error) {
            this.error = data.error;
            this.clearError();
          }
        })
        .catch(function () {
          this.error = 'An unexpected error has occured.';
          this.clearError();
        });
    },
    clearError: function () {
      setTimeout(function () {
        this.error = null;
      }.bind(this), 5000);
    }
  }
};
</script>
