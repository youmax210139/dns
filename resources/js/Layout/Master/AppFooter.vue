<template>
  <footer class="footer">
    <div class="container-fluid">
      <nav>
        <ul>
          <li>
            <a href="/">{{ $page.app.name }}</a>
          </li>
        </ul>
      </nav>
      <div class="copyright" id="copyright">
        &copy; {{ $page.date }}, Maintained by Charlie. Coded by
        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
      </div>
    </div>
  </footer>
</template>
<script>
export default {};
</script>