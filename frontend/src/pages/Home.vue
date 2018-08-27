<template>
  <div class="w-100 h-100" >
    <h2 class="mb-4 mt-5 text-center">
      TODO Lists
    </h2>

    <div
      v-show="loading"
      class="text-center text-muted"
    >
      <h4>Loading...</h4>
    </div>

    <div v-show="groups">
      <group-form @groupCreated="onGroupCreated" />

      <draggable
        v-model="groups"
        :options="draggableOptions"
      >
        <transition-group
          tag="div"
          name="fade"
          class="card-columns mb-5"
        >
          <div
            v-for="group in groups"
            :key="group.id"
            :class="{'card text-center my-3': true, 'border-success': group.finished}"
            :data-id="group.id"
          >
            <group-title
              :group="group"
              class="draggable-handler"
              @update:group="onUpdateGroup($event, group)"
            />
            <div class="card-body">
              <ol style="text-align: left;">
                <li
                  v-for="todo in group.todo"
                  :class="{'text-success': todo.completed}"
                  :key="todo.id"
                  @mouseover="todoSwowEditById = todo.id"
                  @mouseout="todoSwowEditById = null"
                >
                  <todo-checkbox
                    v-if="todoSwowEditById === todo.id"
                    :todo-prop="todo"
                    @input="updateTodoCompleted"
                  />
                  <div v-else>
                    <span v-show="todo.completed">✔</span>
                    {{ todo.title }}
                  </div>
                </li>
              </ol>

              <button
                class="btn btn-secondary"
                @click="$router.push('/group/' + group.id)"
              >
                Open
              </button>
              <button
                class="btn btn-secondary btn-sm ml-2"
                @click="deleteGroup(group)"
              >
                🗑️ Delete
              </button>
            </div>
          </div>
        </transition-group>
      </draggable>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import GroupForm from '@/components/GroupForm.vue'
import GroupTitle from '@/components/GroupTitle.vue'
import TodoCheckbox from '@/components/TodoCheckbox.vue'

export default {
  name: 'Home',
  components: { draggable, GroupForm, GroupTitle, TodoCheckbox },
  data: () => ({
    groups: null,
    todoSwowEditById: null,
    loading: false,
    draggableOptions: {
      draggable: '.card',
      animation: 400,
      handle: '.draggable-handler'
    }
  }),
  mounted () {
    this.fetchGroups()
  },
  methods: {
    async fetchGroups () {
      this.loading = true
      this.groups = await this.$get('groups')
      this.loading = false
    },
    onUpdateGroup (newGroup, groupObj) {
      Object.assign(groupObj, newGroup)
    },
    onGroupCreated (group) {
      this.groups.unshift(group)
    },
    async updateTodoCompleted ({ id, groupId, completed }) {
      const group = this.groups.find(i => i.id === groupId)

      group.todo.find(i => i.id === id).completed = completed
      group.finished =
        (group.todo_completed_count = group.todo.filter(i => i.completed).length) ===
        (group.todo_count = group.todo.length)

      await this.$put('todo/' + id, { completed })
    },
    async deleteGroup ({ id, name }) {
      if (confirm(`Удалить "${name}"?`)) {
        await this.$delete('groups/' + id)
        this.groups = this.groups.filter(i => i.id !== id)
      }
    }
  }
}
</script>
