<template>
  <div :class="{'card-header text-center': true, 'text-success': group.finished}">
    <h4 :class="{'card-title': true, 'text-success': group.finished }">
      <div
        class="mx-auto text-center px-2"
        style="max-width: 350px !important;"
        @mouseover="mouseover"
        @mouseout="editable = false"
      >
        <transition
          name="fade"
          mode="out-in"
        >
          <div
            v-if="editable"
            class="d-flex"
          >
            <input
              v-model="form.name"
              type="text"
              class="form-control form-control-sm"
              placeholder="Name"
            >
            <div
              class="btn-group ml-2"
              role="group"
            >
              <button
                type="button"
                class="btn btn-primary btn-sm"
                @click="save"
              >
                Ок
              </button>
              <button
                type="button"
                class="btn btn-primary btn-sm"
                @click="cancel"
              >
                X
              </button>
            </div>
          </div>
          <span
            v-else
          >
            <span v-if="group.finished">✔</span>
            {{ group.name }}
          </span>
        </transition>
      </div>
    </h4>

    <span class="text-muted">
      Completed
      <span v-show="group.finished">
        all {{ group.todo_count }} tasks
      </span>
      <span v-show="!group.finished">
        {{ group.todo_completed_count }} of {{ group.todo_count }} tasks
      </span>
    </span>
  </div>
</template>

<script>
export default {
  name: 'GroupTitle',
  props: {
    group: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      form: {
        name: this.group.name
      },
      editable: false,
      afterEditable: false
    }
  },
  methods: {
    mouseover () {
      if (this.afterEditable) {
        this.afterEditable = false
        return
      }
      this.editable = true
    },
    async save () {
      await this.$put('groups/' + this.group.id, this.form)
      this.$emit('update:group', {...this.group, ...this.form})
      this.cancel()
    },
    cancel () {
      this.editable = false
      this.afterEditable = true
    }
  }
}
</script>
