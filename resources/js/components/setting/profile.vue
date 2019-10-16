<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout justify-center row>
        <v-flex xs12 md8 ma-2>
          <v-card>
            <v-card-title>Settings</v-card-title>
            <v-card-text>
              <v-layout align-center justify-center row fill-height>
                <v-flex xs12 sm12 md12>
                  <v-text-field v-model="editedValue.id" label="ID" box disabled></v-text-field>
                  <v-text-field v-model="editedValue.name" label="Name" box></v-text-field>
                  <v-text-field v-model="editedValue.userType" label="User Type" box disabled></v-text-field>
                  <v-text-field v-model="editedValue.email" label="Email" disabled box></v-text-field>
                  <v-btn color="primary" @click="editProfile">Update</v-btn>
                </v-flex>
              </v-layout>
            </v-card-text>
          </v-card>
        </v-flex>
        <v-flex xs12 md4 ma-2>
          <v-card>
            <v-card-title>Password</v-card-title>
            <v-card-text>
              <v-layout align-center justify-center row fill-height>
                <v-flex xs12 sm12 md12>
                  <v-text-field
                    v-model="password.oldPassword"
                    label="Current Password*"
                    :rules="passwordRules"
                    required
                    box
                  ></v-text-field>
                  <v-text-field
                    v-model="password.newPassword"
                    label="New Password*"
                    :rules="passwordRules"
                    required
                    box
                  ></v-text-field>
                  <v-text-field
                    v-model="password.confirmPassword"
                    :rules="[
                                             v => v == password.newPassword || 'Should be same as new password']"
                    label="Confirm Password*"
                    required
                    filled
                    box
                  ></v-text-field>
                  <v-btn color="primary" @click="save">Change</v-btn>
                </v-flex>
              </v-layout>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>

    <v-snackbar
      v-model="snackbar"
      :multi-line="'multi-line'"
      :right="x === 'right'"
      :timeout="timeout=5000"
      :top="y === 'top'"
      :vertical="'vertical'"
      :color="snackBarColor"
    >
      {{ text }}
      <v-btn flat @click="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-content>
</template>

<script>
import zmodaldelete from "./../common/zmodaldelete";

export default {
  data: () => ({
    image: "/upload.png",
    loading: false,
    password: {
      oldPassword: "",
      newPassword: "",
      confirmPassword: ""
    },
    passwordRules: [
      v => (v || "").length >= 8 || `Minimum Password charecter is 8`
    ],
    filterValue: {
      year: "",
      month: ""
    },
    dataYear: [],
    dataMonth: [
      {
        id: 1,
        name: "January"
      },
      {
        id: 2,
        name: "February"
      },
      {
        id: 3,
        name: "March"
      },
      {
        id: 4,
        name: "April"
      },
      {
        id: 5,
        name: "May"
      },
      {
        id: 6,
        name: "June"
      },
      {
        id: 7,
        name: "July"
      },
      {
        id: 8,
        name: "Auguest"
      },
      {
        id: 9,
        name: "September"
      },
      {
        id: 10,
        name: "October"
      },
      {
        id: 11,
        name: "November"
      },
      {
        id: 12,
        name: "December"
      }
    ],
    snackBarColor: "green",
    isDelete: false,
    isDeleteAll: false,
    dataIndex: null,
    deleteTitle: "",
    deleteBody: "",
    search: "",
    dataList: [],
    dataPackages: [],
    dataSetting: [],
    selected: [],
    snackbar: false,
    y: "top",
    x: null,
    mode: "",
    text: "Hello, I'm a snackbar",
    edit: true,
    dialog: false,
    dataList: [],
    items: ["Foo", "Bar", "Fizz", "Buzz"],
    headers: [
      { text: "ID", align: "left", value: "id" },
      { text: "Year", value: "year" },
      { text: "Month", value: "month" },
      {
        text: "Customer",
        value: "customer_id"
      },
      { text: "Package", value: "package" },
      { text: "Bill Amount", value: "price" },
      { text: "Action", value: "action" }
    ],
    editedIndex: -1,
    editedValue: {},
    defaultItem: {
      customer_id: "",
      bills: []
    }
  }),
  props: {
    source: String
  },
  components: {
    zmodaldelete
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {},

  created() {
    this.initialize();
    var d = new Date();
    var year = d.getFullYear();
    for (let i = 1; i <= 100; i++) {
      this.dataYear.push(year);
      year++;
    }
  },

  methods: {
    async editProfile() {
      try {
        let { data } = await axios({
          method: "post",
          url: "/app/updateUser",
          data: this.editedValue
        });
        this.text = "Data Updated";
        this.snackBarColor="green"
        this.snackbar = true;

      } catch (e) {
        this.loading = false;
        this.text = "Failed";
        this.snackBarColor="red"
        this.snackbar = true;

      }
    },
    async profileChange(e) {
      console.log(event.target.files[0]);
      this.imageFile = event.target.files[0];
      var blob = event.target.files[0];
      var URLObj = this._getURLObj();
      this.image = URLObj.createObjectURL(blob);
    },
    _getURLObj() {
      return window.URL || window.webkitURL;
    },

    async initialize() {
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/profile"
        });
        this.editedValue = data;
        if (data.image) {
          this.image = data.image;
        }
      } catch (e) {}
    },
    async save() {
      try {
        let { data } = await axios({
          method: "post",
          url: "/app/changepassword",
          data: this.password
        });

        if (data.status == true) {
            this.text = "Data Updated";
            this.snackBarColor="green"
            this.snackbar = true;
        } else {
            this.text = data.message;
            this.snackBarColor="red"
            this.snackbar = true;
        }
      } catch (e) {
            this.text = "Failed";
            this.snackBarColor="red"
            this.snackbar = true;
      }
    },
    async update() {
      try {
        const formData = new FormData();
        formData.append("myFile", this.imageFile);
        for (var key in this.editedValue) {
          formData.append(key, this.editedValue[key]);
        }
        let { data } = await axios({
          method: "post",
          url: "/app/setting",
          data: formData
        });
        this.text = "Data Updated";
        this.snackBarColor = "green";
        this.snackbar = true;
      } catch (e) {
        console.log(e);
        this.text = "Failed";
        this.snackBarColor = "red";
        this.snackbar = true;
      }
    }
  }
};
</script>