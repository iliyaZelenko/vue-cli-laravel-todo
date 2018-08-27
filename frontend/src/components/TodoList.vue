<template>
  <div>
    <draggable
      v-model="group.todo"
      :options="draggableOptions"
      class="row justify-content-center mx-0"
    >
      <div
        v-for="(todo, i) in group.todo"
        :class="{
          [`col-${12 / cols} todo pr-2`]: true,
          'todo--border': isNotLastRow(i)
        }"
        :key="todo.id"
        @mouseover="todoSwowEditByIndex = i"
        @mouseout="todoSwowEditByIndex = null"
      >
        <transition
          name="fade"
          mode="out-in"
        >
          <todo-form
            v-if="todoEditableByIndex === i"
            key="editMode"
            :todo-prop="todo"
            @saveEdited="saveEdited"
            @stopEditing="stopEditing"
          />
          <div
            v-else
            key="watchMode"
          >
            <todo-checkbox
              :todo-prop="todo"
              @input="updateTodo"
            />

            <small
              v-if="todo.comment"
              :class="{
                'todo__info text-muted d-block text-center': true,
                'todo__info--hovered': todoSwowEditByIndex === i
              }"
            >
              {{ todo.comment }}
            </small>
            <br v-else>

            <!--Buttons after mouseover-->
            <transition name="slide-fade">
              <div
                v-if="todoSwowEditByIndex === i"
                class="d-flex justify-content-center"
                style="position: absolute; width: 90%; bottom: 15%;"
              >
                <button
                  class="btn btn-primary mx-2 my-1 btn-circle-sm"
                  @click="todoEditableByIndex = i"
                >
                  ✏️
                </button>
                <button
                  class="btn btn-danger mx-2 my-1 btn-circle-sm"
                  @click="deleteTodo(todo)"
                >
                  🗑️
                </button>
                <button class="btn btn-secondary mx-2 my-1 btn-circle-sm draggable-handler">
                  :::
                </button>
              </div>
            </transition>
          </div>
        </transition>
      </div>
    </draggable>
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import TodoForm from '@/components/TodoForm.vue'
import TodoCheckbox from '@/components/TodoCheckbox.vue'

export default {
  name: 'TodoList',
  components: { TodoForm, TodoCheckbox, draggable },
  props: {
    group: {
      type: Object,
      required: true
    },
    bus: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    cols: 3,
    todoSwowEditByIndex: null,
    todoEditableByIndex: null,
    draggableOptions: {
      draggable: '.todo',
      animation: 400,
      handle: '.draggable-handler'
    }
  }),
  created () {
    this.bus.$on('addTodoAsNotCreated', () => {
      this.todoEditableByIndex = this.group.todo.length - 1
    })
  },
  methods: {
    async updateTodo ({ id, completed }) {
      let todo = this.group.todo.find(i => i.id === id)
      let dateTiemNow = new Date().toISOString().split(/[T\\.]/).slice(0, 2).join(' ') // UTC format!(with time)
      let completedAt = completed ? dateTiemNow : null

      const dataUpdate = {
        completed,
        completed_at: completedAt
      }
      Object.assign(todo, dataUpdate)

      this.bus.$emit('todoEdited')
      await this.$put('todo/' + id, {
        completed,
        completed_at: completedAt
      })
    },
    async saveEdited ({ id, comment, title }) {
      if (id === -1) {
        this.bus.$emit('todoCreated', await this.createTodo({ group_id: this.group.id, comment, title }))
      } else {
        await this.$put('todo/' + id, { comment, title })
      }
      this.todoEditableByIndex = null
    },
    async deleteTodo ({ id, title }) {
      if (confirm(`Удалить "${title}"?`)) {
        await this.$delete('todo/' + id)
        this.bus.$emit('todoDeleted', id)
      }
    },
    async createTodo (todo) {
      return this.$post('todo/', todo)
    },
    stopEditing () {
      this.bus.$emit('stopEditing', this.todoEditableByIndex)
      this.todoEditableByIndex = null
    },
    // used for a border
    isNotLastRow (i) {
      const remainder = this.group.todo.length % this.cols
      if (remainder) {
        return remainder < this.group.todo.length - i
      }
      return this.group.todo.length - i > this.cols
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="stylus">
  .todo__info
    transition all ease-in 200ms
    // filter: blur(2px)
  .todo__info--hovered
    opacity 0.3

  .todo
    display block
    padding .75rem 1.25rem
    background-color #fff

  .todo--border
    border-bottom 1px solid rgba(0, 0, 0, .125)

  /*line-height 1.65*/
  .btn-circle-sm
    width 22px
    height 22px
    text-align center
    padding 1px 0 0 2px
    font-size 12px
    border-radius 30px
    line-height 1.65
</style>
