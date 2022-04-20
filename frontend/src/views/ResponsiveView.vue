<script>
import { reactive } from "vue";
export default {
  name: "get-request-set-headers",
  data() {
    return {
      stockrequest: [],
      form: { nik: "", name: "", department: "", date_requested: "" },
      nik: "",
      products: [],
      rows: [
        {
          barang: "",
          lokasi: "",
          tersedia: "",
          qty: "",
          satuan: "",
          keterangan: "",
          status: "",
        },
      ],
    };
  },
  created() {
    // GET request using fetch with set headers
    const headers = { "Content-Type": "application/json" };
    fetch("http://localhost:8000/api/stock-request", { headers })
      .then((response) => response.json())
      .then((data) => (this.stockrequest = data));
    fetch("http://localhost:8000/api/product", { headers })
      .then((response) => response.json())
      .then((data) => (this.products = data));
  },
  methods: {
    checkNik(event) {
      this.nik = event.target.value;
      const headers = { "Content-Type": "application/json" };
      fetch("http://localhost:8000/api/user/" + this.nik, { headers })
        .then((response) => response.json())
        .then(
          (data) => (
            (this.form.name = data.name),
            (this.form.department = data.department.name)
          )
        );
    },
    getBarang(event, index) {
      this.barang = event.target.value;
      let row = this.rows[index];
      console.log(this.barang);
      console.log(row);
      const headers = { "Content-Type": "application/json" };
      fetch("http://localhost:8000/api/product/" + this.barang, { headers })
        .then((response) => response.json())
        .then((data) => console.log(data));
    },
    addRow: function () {
      this.rows.push({
        barang: "",
        lokasi: "",
        tersedia: "",
        qty: "",
        satuan: "",
        keterangan: "",
        status: "",
      });
    },
    deleteRow(row) {
      var idx = this.rows.indexOf(row);
      if (idx > -1) {
        this.rows.splice(idx, 1);
      }
    },
    getProduct(event, row) {
      const headers = { "Content-Type": "application/json" };
      fetch("http://localhost:8000/api/product/" + event.target.value, {
        headers,
      })
        .then((response) => response.json())
        .then(
          (data) => (
            (row.lokasi = data.location.name),
            (row.tersedia = data.qty),
            (row.satuan = data.unit.name),
            (row.keterangan = data.note),
            data.qty == 0 ? (row.status = "Kosong") : ""
          )
        );
    },
    checkStatus(event, row) {
      console.log(event.target.value);
      if (row.tersedia == 0) {
        row.status = "Kosong";
      } else if (event.target.value > row.tersedia) {
        row.status = "Sebagian";
      } else {
        row.status = "Terpenuhi";
      }
    },
    async submitSR() {
      let jsondata = { head: this.form, line: this.rows };
      const headers = {
        Accept: "application/json",
        "Content-Type": "application/json",
      };
      await fetch("http://localhost:8000/api/stock-request", {
        method: "POST",
        headers: headers,
        body: JSON.stringify(jsondata),
      })
        .then((response) => response.json())
        .then();
    },
  },
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
      <BaseBlock>
        <div class="row">
          <div class="col-12 text-end">
            <!-- Size: Large -->

            <button
              type="button"
              class="btn btn-alt-primary push"
              data-bs-toggle="modal"
              data-bs-target="#modal-block-large"
            >
              + Add New
            </button>
            <!-- END Size: Large -->
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-vcenter">
            <thead>
              <tr>
                <th style="width: 30%">Nomor SR</th>
                <th>Pegawai</th>
                <th>NIK</th>
                <th style="width: 15%">Tanggal</th>
                <th class="text-center" style="width: 100px">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="sr in stockrequest" :key="sr.id">
                <td class="fw-semibold fs-sm">
                  {{ sr.code }}
                </td>
                <td class="fs-sm">
                  {{ sr.user.name }}
                </td>
                <td class="fs-sm">
                  {{ sr.user.nik }}
                </td>
                <td>
                  {{ sr.created_at }}
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <RouterLink
                      :to="{
                        name: 'stock-request-detail',
                        params: { id: sr.id },
                      }"
                      class="btn btn-sm btn-alt-secondary"
                    >
                      <i class="fa fa-fw fa-eye"></i>
                    </RouterLink>
                    <button type="button" class="btn btn-sm btn-alt-secondary">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </BaseBlock>
      <!-- END Full Table -->
    </div>
    <!-- Large Block Modal -->
    <div
      class="modal"
      id="modal-block-large"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-block-large"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <BaseBlock title="Tambah Permintaan Barang" transparent class="mb-0">
            <template #options>
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
              <form>
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
                      @input="checkNik($event)"
                    />
                  </div>
                  <div class="mb-4 col-4">
                    <label class="form-label" for="block-form1-name"
                      >Nama</label
                    >
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
                      v-model="form.date_requested"
                    />
                  </div>
                </div>
                <div class="block-content fs-sm row">
                  <div class="table-responsive">
                    <table
                      class="table table-bordered table-striped table-vcenter"
                    >
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
                          <th class="text-center">*</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(row, index) in rows" :key="row.id">
                          <td>
                            {{ index + 1 }}
                          </td>
                          <td>
                            <select
                              id="product"
                              class="form-control"
                              @change="getProduct($event, row)"
                              v-model="row.barang"
                            >
                              <option disabled value="" selected>
                                Select Product
                              </option>
                              <option
                                v-for="product in products"
                                :key="product.id"
                                :value="product.id"
                              >
                                {{ product.name }}
                              </option>
                            </select>
                            <!-- <input
                            class="form-control"
                            type="text"
                            v-model="row.barang"
                            @input="getBarang($event, index)"
                          /> -->
                          </td>
                          <td>
                            <input
                              class="form-control"
                              type="text"
                              v-model="row.lokasi"
                              readonly
                            />
                          </td>
                          <td>
                            <input
                              class="form-control text-right"
                              type="number"
                              min="0"
                              readonly
                              v-model="row.tersedia"
                            />
                          </td>
                          <td>
                            <input
                              class="form-control text-right"
                              type="number"
                              min="0"
                              v-model="row.qty"
                              @change="checkStatus($event, row)"
                            />
                          </td>
                          <td>
                            <input
                              readonly
                              class="form-control text-right"
                              type="text"
                              v-model="row.satuan"
                            />
                          </td>
                          <td>
                            <input
                              readonly
                              class="form-control text-right"
                              type="text"
                              v-model="row.keterangan"
                            />
                          </td>
                          <td>
                            <input
                              readonly
                              class="form-control text-right"
                              type="text"
                              v-model="row.status"
                            />
                          </td>
                          <td scope="row" class="trashIconContainer">
                            <i
                              class="far fa-trash-alt"
                              @click="deleteRow(row)"
                            ></i>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row mb-2">
                      <div class="col-12 text-end">
                        <button
                          type="button"
                          class="btn btn-success"
                          @click="addRow()"
                        >
                          + Tambah
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                  <button
                    type="button"
                    class="btn btn-sm btn-alt-secondary me-1"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    @click="submitSR()"
                  >
                    Submit
                  </button>
                </div>
              </form>
            </template>
          </BaseBlock>
        </div>
      </div>
    </div>
    <!-- END Large Block Modal -->
  </div>
  <!-- END Page Content -->
</template>
