<div class="topbar">
  <div class="container flex-column flex-md-row">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-home fz-1-15rem mr-2"></i>
      <a href="https://www.pu.go.id/"
        class="topbar-link"
        target="_blank">PUPR</a>
      <div class="mx-2">|</div>
      <a href="https://sda.pu.go.id/"
        class="topbar-link"
        target="_blank">Ditjen SDA</a>
    </div>
    <div class="flex"></div>
    <div class="d-flex align-items-center">
      <div class="d-flex align-items-center mr-3">
        <i class="mdi mdi-calendar-month fz-1-15rem mr-1"></i>
        {{ now()->isoFormat('DD MMMM YYYY') }}
      </div>
      <ul class="topbar-social">
        <x-web.medsos-link />
      </ul>
    </div>
  </div>
</div>
