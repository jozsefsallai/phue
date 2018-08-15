<template lang="pug">
  div
    .alert.success(v-if='success') {{ success }}
    .alert.error(v-if='error') {{ error }}
    .tasks
      .col
        h3 Pending Tasks
        .list(v-if='pendingTasks && pendingTasks.length')
          task(
            v-for='task, idx in pendingTasks'
            :task='task'
            :key='idx'
            @success='handleSuccess'
            @error='handleError'
          )
        div(v-else=true) Woohoo! There are no pending tasks.
      .col
        h3 Finished Tasks
        .list(v-if='finishedTasks && finishedTasks.length')
          task(
            v-for='task, idx in finishedTasks'
            :task='task'
            :key='idx'
            @success='handleSuccess'
            @error='handleError'
          )
        div(v-else=true) There are no finished tasks. You should get to working!
</template>

<script>
import task from 'components/tasks/Task';

export default {
  name: 'task-list',
  components: {
    task
  },
  props: {
    pendingTasks: Array,
    finishedTasks: Array
  },
  data: function () {
    return {
      success: null,
      error: null
    };
  },
  methods: {
    handleSuccess: function (message) {
      this.success = message;
      this.clearSuccess();
    },
    handleError: function (error) {
      this.error = error;
      this.clearError();
    },
    clearSuccess: function () {
      setTimeout(function () {
        this.success = null;
      }.bind(this), 5000);
    },
    clearError: function () {
      setTimeout(function () {
        this.error = null;
      }.bind(this), 5000);
    }
  }
};
</script>

<style lang="scss">
  .tasks {
    display: flex;

    .col {
      width: 50%;
      box-sizing: border-box;
      padding: 10px;

      .list {
        .task {
          padding: 5px;
          border-top: 1px solid #cecece;

          .task-info, .task-edit-form form {
            display: flex;
            align-items: center;
            justify-content: space-between;
          }

          &:last-child {
            border-bottom: 1px solid #cecece;
          }

          &:nth-child(odd) {
            background: #f7f7f7;
          }
        }
      }

      h3 {
        margin-top: 0;
      }
    }
  }
</style>
