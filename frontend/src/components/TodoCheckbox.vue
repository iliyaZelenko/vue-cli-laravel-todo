<template>
  <div class="custom-control custom-checkbox">
    <input
      :id="'todo' + todo.id"
      :name="'todo-' + todo.id"
      :checked="todo.completed"
      type="checkbox"
      class="custom-control-input"
      @input="$emit('input', {
        id: todo.id,
        groupId: todo.group_id,
        completed: !todo.completed
      })"
    >
    <label
      :for="'todo' + todo.id"
      :class="['custom-control-label', todo.completed && 'text-success']"
    >
      {{ todo.title }}
    </label>
  </div>
</template>

<script>
export default {
  name: 'TodoCheckbox',
  props: {
    todoProp: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      todo: this.todoProp
    }
  }
}
</script>
