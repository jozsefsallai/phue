<template lang="pug">
  app-template
    h2.title Tasks
    task-list(
      v-if='tasks && tasks.length',
      :finishedTasks='finishedTasks'
      :pendingTasks='pendingTasks'
    )
    p(v-else=true) There are no tasks.
    .create-task-button
      a(href='javascript://', @click='toggleCreateForm') Create Task
    create-task(v-if='createTaskFormOpened', @taskCreated='handleTaskCreated')
    .alert.success(v-if='success') {{ success }}
</template>

<script>
import AppTemplate from 'components/AppTemplate';
import TaskList from 'components/tasks/TaskList';
import CreateTask from 'components/tasks/CreateTask';

export default {
  name: 'index-page',
  components: {
    'app-template': AppTemplate,
    'task-list': TaskList,
    'create-task': CreateTask
  },
  data: function () {
    return {
      createTaskFormOpened: false,
      success: null
    };
  },
  computed: {
    tasks: function () {
      return this.$store.state.tasks;
    },
    finishedTasks: function () {
      if (this.tasks) {
        return this.tasks.filter(t => t.done === true);
      }
    },
    pendingTasks: function () {
      if (this.tasks) {
        return this.tasks.filter(t => t.done === false);
      }
    }
  },
  mounted: function () {
    if (!this.tasks) {
      this.$store.dispatch('fetchTasks');
    }
  },
  methods: {
    toggleCreateForm: function () {
      this.createTaskFormOpened = !this.createTaskFormOpened;
    },
    handleTaskCreated: function () {
      this.createTaskFormOpened = false;
      this.success = 'Task created successfully!';
      this.clearSuccess();
    },
    clearSuccess: function () {
      setTimeout(function () {
        this.success = null;
      }.bind(this), 5000);
    }
  }
};
</script>

<style lang="scss">
  @import 'src/styles/colors';
  
  .create-task-button {
    text-align: center;
    margin: 30px 0;

    a {
      display: inline-block;
      background: $theme;
      color: #fff;
      font-weight: 700;
      padding: 10px 25px;

      &:hover {
        background: $theme-darker;
      }
    }
  }
</style>
