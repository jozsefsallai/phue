<template lang="pug">
  .task
    .task-edit-form(v-if='editMode')
      form(@submit='handleSubmit')
        input(
          name='name'
          placeholder='Task Name'
          :value='task.name'
          autocomplete='off'
        )
        a(href='javascript://', @click='toggleEditMode') Cancel
    .task-info(v-else=true)
      span.task-name(:class='{ done: task.done }') 
        | {{ task.name }} -
        |
        a(href='javascript://', @click='toggleEditMode')
          i.fa.fa-pencil
        a(href='javascript://', @click='deleteTask')
          i.fa.fa-times
      button(v-if='task.done', @click='markAsPending') Mark as Pending
      button(v-else=true, @click='markAsDone') Mark as Done
</template>

<script>
import axios from 'axios';

export default {
  name: 'task',
  props: {
    task: Object
  },
  data: function () {
    return {
      editMode: false
    };
  },
  methods: {
    markAsPending: function () {
      alert('Under construction');
    },
    markAsDone: function () {
      alert('Under construction');
    },
    toggleEditMode: function (e) {
      e.preventDefault();
      this.editMode = !this.editMode;
    },
    handleSubmit: function (e) {
      e.preventDefault();
      const name = e.target.name.value;
      const url = `/api/tasks/${this.task.id}`;
      const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      };

      axios.patch(url, {
        name
      }, { credentials: 'same-origin', headers })
        .then(({ data }) => {
          if (data.ok) {
            this.$store.commit('updateTask', data.record);
            this.editMode = false;
            this.$emit('success', 'Task edited successfully!');
          } else if (data.error) {
            this.$emit('error', data.error);
          } else {
            this.$emit('error', 'An unexpected error has occurred.');
          }
        });
    },
    deleteTask: function () {
      if (confirm('Are you sure you want to delete this task?')) {
        const url = `/api/tasks/${this.task.id}`;
        const headers = {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        };
        axios.delete(url, {}, {
          credentials: 'same-origin',
          headers
        })
          .then(({ data }) => {
            if (data.ok) {
              this.$store.commit('removeTask', data.record);
              this.$emit('success', 'Task removed successfully!');
            } else if (data.error) {
              this.$emit('error', data.error);
            } else {
              this.$emit('error', 'An unexpected error has occurred.');
            }
          });
      }
    },
    changeState: function (newState) {
      const url = `/api/tasks/${newState}/${this.task.id}`;
      const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      };
      axios.patch(url, {}, {
        credentials: 'same-origin',
        headers
      })
        .then(({ data }) => {
          if (data.ok) {
            this.$store.commit('updateTask', data.record);
          } else if (data.error) {
            this.$emit('error', data.error);
          } else {
            this.$emit('error', 'An unexpected error has occurred.');
          }
        });
    },
    markAsPending: function (e) {
      e.preventDefault();
      this.changeState('pending');
    },
    markAsDone: function (e) {
      e.preventDefault();
      this.changeState('done');
    }
  }
};
</script>
