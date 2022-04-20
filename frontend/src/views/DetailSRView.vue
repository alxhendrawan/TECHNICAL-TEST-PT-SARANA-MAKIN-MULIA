<script>
import { reactive } from "vue";
export default {
  name: "detail-sr",
  data() {
    return {
      form: { nik: "", name: "", department: "", date_requested: "" },
      rows: [],
    };
  },
  created() {
    let id = this.$route.params.id;
    console.log(id);
    // // GET request using fetch with set headers
    const headers = { "Content-Type": "application/json" };
    fetch("http://localhost:8000/api/stock-request/header/" + id, {
      headers,
    })
      .then((response) => response.json())
      .then(
        (data) => (
          (this.form.nik = data.user.nik),
          (this.form.name = data.user.name),
          (this.form.department = data.user.department.name),
          (this.form.date_requested = data.date_requested)
        )
      );
    fetch("http://localhost:8000/api/stock-request/line/" + id, {
      headers,
    })
      .then((response) => response.json())
      .then((data) => (this.rows = data));
  },
  methods: {},
};
</script>

<template>
  <div>
    <!-- Hero -->
    <BasePageHeading title="Stock Request">
      <template #extra>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">Stock Request</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Index</li>
          </ol>
        </nav>
      </template>
    </BasePageHeading>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
      <!-- Full Table -->
      <BaseBlock title="Detail Permintaan Barang" transparent class="mb-0">
        <template>
          <button
            type="button"
            class="btn-block-option"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <i class="fa fa-fw fa-times"></i>
          </button>
        </template>

        <template #content>
          <div class="block-content fs-sm row">
            <div class="mb-4 col-4">
              <label class="form-label" for="block-form1-nik">NIK</label>
              <input
                type="text"
                class="form-control form-control-alt"
                id="block-form1-nik"
                name="block-form1-nik"
                placeholder="Enter your nik.."
                v-model="form.nik"
              />
            </div>
            <div class="mb-4 col-4">
              <label class="form-label" for="block-form1-name">Nama</label>
              <input
                type="text"
                class="form-control form-control-alt"
                id="block-form1-name"
                name="block-form1-name"
                v-model="form.name"
                readonly
              />
            </div>
            <div class="mb-4 col-4">
              <label class="form-label" for="block-form1-department"
                >Department</label
              >
              <input
                type="text"
                class="form-control form-control-alt"
                id="block-form1-department"
                name="block-form1-department"
                v-model="form.department"
                readonly
              />
            </div>
            <div class="mb-4 col-4">
              <label class="form-label" for="block-form1-date"
                >Tanggal Permintaan</label
              >
              <input
                type="date"
                class="form-control form-control-alt"
                id="block-form1-date"
                name="block-form1-date"
                placeholder="Enter your date.."
              />
            </div>
          </div>
          <div class="block-content fs-sm row">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-vcenter">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Barang</th>
                    <th>Lokasi</th>
                    <th>Tersedia</th>
                    <th>Kuantiti</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in rows" :key="row.id">
                    <td>
                      {{ index + 1 }}
                    </td>
                    <td>
                      {{ row.product.name }}
                      <!-- <input
                            class="form-control"
                            type="text"
                            v-model="row.barang"
                            @input="getBarang($event, index)"
                          /> -->
                    </td>
                    <td>
                      {{ row.product.location.name }}
                    </td>
                    <td>
                      {{ row.product.qty }}
                    </td>
                    <td>
                      {{ row.qty }}
                    </td>
                    <td>
                      {{ row.product.unit.name }}
                    </td>
                    <td>
                      {{ row.notes }}
                    </td>
                    <td>
                     {{row.status == 1 ? "Terpenuhi" : "Sebagian"}}
                    </td>
                 
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </BaseBlock>
      <!-- END Full Table -->
    </div>
    <!-- Large Block Modal -->

    <!-- END Large Block Modal -->
  </div>
  <!-- END Page Content -->
</template>
