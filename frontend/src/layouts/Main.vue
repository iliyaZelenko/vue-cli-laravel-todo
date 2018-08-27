<template>
  <div
    class="d-flex flex-column"
    style="height: 100%;"
  >
    <nav
      class="navbar navbar-expand-lg navbar-light"
      style="background-color: #e3f2fd;"
    >
      <a
        class="navbar-brand"
        href="#"
      >
        {{ appName }}
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarColor03"
        aria-controls="navbarColor03"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"/>
      </button>

      <div
        id="navbarColor03"
        class="collapse navbar-collapse"
      >
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <router-link
              to="/"
              class="nav-link"
            >
              Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/about"
              class="nav-link"
            >
              About
            </router-link>
          </li>
        </ul>
      </div>
    </nav>

    <div
      class="container d-flex align-items-center justify-content-center"
      style="height: 100%;"
    >
      <transition
        name="router"
        mode="out-in"
      >
        <router-view/>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    appName: process.env.VUE_APP_SECRET
  })
}
</script>
