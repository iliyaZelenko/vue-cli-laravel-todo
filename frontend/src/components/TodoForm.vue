<template>
  <div class="d-flex align-items-center text-muted float-left">
    <div>
      <input
        v-model="todo.title"
        type="text"
        class="form-control form-control-sm rounded-top"
        style="border-bottom-left-radius: 0!important; border-bottom-right-radius: 0!important;"
        placeholder="Title"
      >
      <input
        v-model="todo.comment"
        type="text"
        class="form-control form-control-sm"
        style="border-top-left-radius: 0!important; border-top-right-radius: 0!important;"
        placeholder="Comment"
      >
    </div>
    <div
      class="btn-group ml-2"
      role="group"
    >
      <button
        type="button"
        class="btn btn-primary btn-sm"
        @click="$emit('saveEdited', todo)"
      >
        Ок
      </button>
      <button
        type="button"
        class="btn btn-primary btn-sm"
        @click="$emit('stopEditing')"
      >
        X
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TodoForm',
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
  },
  watch: {
    todo (todo) {
      this.$emit('input', todo)
    }
  }
}
</script>
