<template>
  <section class="forms">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" @submit.prevent="submit">
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">域名或IP地址</label>
                  <div class="col-sm-9">
                    <input
                      id="inputHorizontalSuccess"
                      placeholder="example.com"
                      class="form-control form-control-success"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Ping检测</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {};
</script>
