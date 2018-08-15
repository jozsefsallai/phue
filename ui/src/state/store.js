import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import find from 'lodash.find';
import without from 'lodash.without';

Vue.use(Vuex);

const initialState = {
  tasks: null
};

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  state: initialState,

  mutations: {
    reset: state => Object.assign(state, initialState),

    setTasks: function (state, tasks) {
      state.tasks = tasks;
    },

    createTask: function (state, task) {
      const newTasks = state.tasks.slice(0);
      newTasks.push(task);
      state.tasks = newTasks;
    },

    updateTask: function (state, task) {
      const targetTask = find(state.tasks, { id: task.id });
      if (!targetTask) {
        throw new Error(`Cannot update task ${task.id}`);
      }
      const newTask = Object.assign({}, targetTask, task);
      const newTasks = without(state.tasks, targetTask);
      newTasks.push(newTask);
      newTasks.sort((a, b) => a.id - b.id);
      state.tasks = newTasks;
    },

    removeTask: function (state, task) {
      const targetTask = find(state.tasks, { id: task.id });
      if (!targetTask) {
        throw new Error(`Cannot remove task ${task.id}`);
      }
      const newTasks = without(state.tasks, targetTask);
      state.tasks = newTasks;
    }
  },

  actions: {
    fetchTasks: function({ state, commit }) {
      const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      };

      axios.get('/api/tasks', { credentials: 'same-origin', headers })
        .then(({ data }) => {
          commit('setTasks', data.records);
        });
    }
  }
});

export default store;
