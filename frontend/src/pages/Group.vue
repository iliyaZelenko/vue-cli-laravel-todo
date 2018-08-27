<template>
  <div v-if="group">
    <div class="mb-2 clearfix">
      <router-link
        to="/"
        class="float-left"
      >
        🡄  Go back
      </router-link>
      <button
        class="btn btn-danger btn-sm float-right mx-1"
        @click="deleteGroup"
      >
        🗑️ Delete
      </button>
      <button
        role="button"
        class="btn btn-primary btn-dark btn-sm float-right mx-1"
        @click="addTodoAsNotCreated"
      >
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABaUlEQVQ4T2NkoBAw4tIfujt0PwMDgwNU/sBq19WO2NTiNCBoR9B/MzMzsJ5Tp04xrPNYh1UtTgP8tvj9Nzc3Bxtw8uRJhk0+m0gzwHO9538LCwuwASdOnGDYHridNAOcVzr/t7S0BBtw/Phxhr3he3EbYLvYdj8zM7MDGxsbAwizsrKCsaKiItiA+/fvM/z+/RuMf/36BcZ///49cDj2sCPYVLM5Zv+DgoJQAvnr168MX758AYvx8PAwcHNzo8ivW7eO4VTKKUawAQbTDP7b2NiQlCKOHDnCcCHrAsQAzX7N/SwsLA4gZ4O8wM7ODvaCkpIS2NB79+6Bnf/z50+w80HsP3/+HLheeB3iBWxAuVP5v52dHVjq0KFDDHfL75IWC7LNsv/t7e3BBhw8eJDhce1j0gyQqJP47+AASckHDhxgeNH0gjQDRKpE/js6QpL//v37Gd60vSHNAMFyQZTM9L7zPWmZidg4BQC6j4QRBvLeBAAAAABJRU5ErkJggg==">
        Add TODO
      </button>
    </div>

    <div
      :class="{'card mx-auto mb-5': true, 'border-success': group.finished}"
      style="width: 55rem;"
    >
      <!--header-->
      <group-title
        :group="group"
        @update:group="updateGroup"
      />

      <!--todos-->
      <todo-list
        :group="group"
        :bus="bus"
      />
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import GroupTitle from '@/components/GroupTitle.vue'
import TodoList from '@/components/TodoList.vue'

export default {
  name: 'Group',
  components: { GroupTitle, TodoList },
  props: {
    id: {
      type: String,
      default: null
    }
  },
  data: () => ({
    group: null,
    bus: new Vue()
  }),
  mounted () {
    this.fetch()

    this.bus.$on('stopEditing', id => this.resetTodoAsNotCreated())
    this.bus.$on('todoCreated', createdTodo => {
      this.resetTodoAsNotCreated()
      this.group.todo.push(createdTodo)
      this.updateGroupStat()
    })
    this.bus.$on('todoEdited', id => {
      this.updateGroupStat()
    })
    this.bus.$on('todoDeleted', id => {
      this.group.todo = this.group.todo.filter(i => i.id !== id)
      this.updateGroupStat()
    })
  },
  methods: {
    async fetch () {
      this.group = await this.$get('groups/' + this.id)
    },
    updateGroup (newGroup) {
      this.group = newGroup
    },
    addTodoAsNotCreated () {
      this.resetTodoAsNotCreated()
      this.group.todo.push({
        id: -1,
        title: '',
        comment: '',
        completed: false,
        created_at: null,
        completed_at: null
      })
      // this.updateGroupStat()
      this.bus.$emit('addTodoAsNotCreated')
    },
    async deleteGroup () {
      if (confirm(`Удалить группу?`)) {
        await this.$delete('groups/' + this.group.id)
        this.$router.push('/')
      }
    },
    resetTodoAsNotCreated () {
      this.group.todo = this.group.todo.filter(i => i.id !== -1)
    },
    updateGroupStat () {
      this.group.finished =
        (this.group.todo_completed_count = this.group.todo.filter(i => i.completed).length) ===
        (this.group.todo_count = this.group.todo.length)
    }
  }
}
</script>
