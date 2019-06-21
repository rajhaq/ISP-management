<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout justify-center row>
        <v-flex xs12>
          <v-toolbar flat color="white">
            <v-toolbar-title>User List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog
              v-model="dialog"
              fullscreen
              hide-overlay
              transition="dialog-bottom-transition"
            >
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on" @click="close()">New User</v-btn>
              </template>
              <v-card>
                <v-toolbar dark color="primary">
                  <v-btn icon dark @click="dialog = false">
                    <v-icon>close</v-icon>
                  </v-btn>
                  <v-toolbar-title>Settings</v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-toolbar-items>
                    <v-btn dark flat @click="dialog = false">Save</v-btn>
                  </v-toolbar-items>
                </v-toolbar>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs4>
                        <v-subheader>Name</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-text-field
                        outline
                          v-model="editedItem.name"
                          label="Name"
                          :rules="[v => !!v || 'Name is required']"
                          required
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Position</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-text-field
                        outline
                          v-model="editedItem.position"
                          label="Position"
                          :rules="[v => !!v || 'Position is required']"
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Permission</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-select
                        outline
                          v-model="editedItem.permissionValue"
                          :items="permissionItems"
                          attach
                          chips
                          label="Permission"
                          multiple
                        ></v-select>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Gender</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-select outline
                         v-model="editedItem.gender" :items="genderItems" label="Gender">

                        </v-select>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Phone</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-combobox 
                        label="Phone"
                        outline
                        v-model="editedItem.phone" hide-selected multiple small-chips>
                          <template v-slot:no-data>
                            <v-list-tile>
                              <v-list-tile-content>
                                <v-list-tile-title>
                                  No results matching "
                                  <strong>{{ search }}</strong>". Press
                                  <kbd>enter</kbd> to create a new one
                                </v-list-tile-title>
                              </v-list-tile-content>
                            </v-list-tile>
                          </template>
                        </v-combobox>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Email</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-combobox 
                        outline
                        label="Email"
                        v-model="editedItem.email" hide-selected multiple small-chips>
                          <template v-slot:no-data>
                            <v-list-tile>
                              <v-list-tile-content>
                                <v-list-tile-title>
                                  No results matching "
                                  <strong>{{ search }}</strong>". Press
                                  <kbd>enter</kbd> to create a new one
                                </v-list-tile-title>
                              </v-list-tile-content>
                            </v-list-tile>
                          </template>
                        </v-combobox>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Speed Dial</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-combobox
                        label="Speed Dial"
                        outline
                          v-model="editedItem.speedial"
                          hide-selected
                          multiple
                          small-chips
                        >
                          <template v-slot:no-data>
                            <v-list-tile>
                              <v-list-tile-content>
                                <v-list-tile-title>
                                  No results matching "
                                  <strong>{{ search }}</strong>". Press
                                  <kbd>enter</kbd> to create a new one
                                </v-list-tile-title>
                              </v-list-tile-content>
                            </v-list-tile>
                          </template>
                        </v-combobox>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Nickname</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-text-field
                        outline v-model="editedItem.nickname" label="Nickname"></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Notes</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-textarea outline
                        v-model="editedItem.notes" label="Notes"></v-textarea>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Eligible on call</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-textarea outline
                        v-model="editedItem.call_eligible" label="Eligible on call"></v-textarea>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Routine Instrucions</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-textarea outline
                        v-model="editedItem.routine" label="Routine Instrucions"></v-textarea>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Emergency Instrucions</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-textarea outline
                        v-model="editedItem.emergency" label="Emergency Instrucions"></v-textarea>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>On Call Instrucions</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-textarea outline
                        v-model="editedItem.oncall" label="On Call Instrucions"></v-textarea>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Genral Instrucions</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-textarea outline
                        v-model="editedItem.general" label="Genral Instrucions"></v-textarea>
                      </v-flex>
                      <v-flex xs4>
                        <v-subheader>Message Handling Instruction</v-subheader>
                      </v-flex>
                      <v-flex xs8>
                        <v-textarea
                        outline
                          v-model="editedItem.message_handling"
                          label="Message Handling Instruction"
                        ></v-textarea>
                      </v-flex>
                    </v-layout>
                    <v-layout row>
              <v-flex offset-lg8></v-flex>
              <v-flex xs12 lg2 ma-1>
                <v-btn color="error" dark large block  @click="dialog = false">Cancel</v-btn>
              </v-flex>
              <v-flex xs12 lg2 ma-1>
                <v-btn color="error" dark large block @click="save">Add</v-btn>
              </v-flex>
            </v-layout>
                  </v-container>
                </v-card-text>

              </v-card>
            </v-dialog>
          </v-toolbar>
          <v-data-table
      :headers="headers"
      :items="dataDirectories"
      :expand="expand"
      item-key="name"
      class="elevation-1"
    >
            <template v-slot:items="props">
              <tr @click="props.expanded = !props.expanded">
              <td>{{ props.item.id }}</td>
              <td>{{ props.item.name }}</td>
              <td>{{ props.item.position }}</td>
              <td>{{ props.item.gender }}</td>
              <td class="justify-center layout px-0">
                <v-icon small class="mr-2" @click="editItem(props.item)" color="primary">edit</v-icon>

                <!-- <v-icon
                        small
                        @click="deleteItem(props.item)"
                    >
                        delete
                </v-icon>-->
              </td>
              </tr>
            </template>
            <template v-slot:expand="props">
        <v-card flat>
          <v-card-text>{{ props.item.gender }}</v-card-text>
        </v-card>
      </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
          </v-data-table>
        </v-flex>
      </v-layout>
    </v-container>
    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="timeout"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
    >
      {{ text }}
      <v-btn color="pink" flat @click="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-content>
</template>

<script>
export default {
  data: () => ({
    expand:true,
    snackbar: false,
    y: "top",
    x: null,
    mode: "",
    timeout: 6000,
    text: "Hello, I'm a snackbar",
    edit: true,
    dialog: false,
    dataDirectories: [],
    userType: ["Admin", "Supervisor", "Team Leader", "Operator", "Ban"],

    headers: [
      { text: "ID", align: "left", value: "id" },
      {
        text: "Name",
        value: "name"
      },
      { text: "Position", value: "position" },
      { text: "Gender", value: "gender" }
    ],
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+/.test(v) || "E-mail must be valid"
    ],
    usernameRules: [
      v => !!v || "UserID is required",
      v => (v || "").indexOf(" ") < 0 || "No spaces are allowed"
    ],
    passwordRules: [
      v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
    ],

    editedIndex: -1,
    editedItem: {
      name: "",
      email: "",
      username: "",
      userType: "",
      permissionValue: [],
      phone: [],
      email: [],
      speedial: []
    },
    defaultItem: {},
    activator: null,
    attach: null,
    colors: ["green", "purple", "indigo", "cyan", "teal", "orange"],
    editing: null,
    index: -1,
    permissionItems: ["Get Message", "Make Changes", "Billing", "Full Access"],
    genderItems: ["Male", "Female", "Other"],
    items: ["Gaming", "Programming", "Vue", "Vuetify"],
    model: ["Vuetify"],
    nonce: 1,
    menu: false,

    x: 0,
    search: null,
    y: 0
  }),
  props: {
    source: String
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {
    model(val) {
      if (val.length > 5) {
        this.$nextTick(() => this.model.pop());
      }
    }
  },
  created() {
    this.initialize();
  },

  methods: {
    async initialize() {
      try {
        let { data } = await axios({
          method: "get",
          url: "/api/directories"
        });
        this.dataDirectories = data;
      } catch (e) {}
    },

    editItem(item) {
      this.edit = false;
      this.editedIndex = this.dataDirectories.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.dataDirectories.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.dataDirectories.splice(index, 1);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    async save() {
      if (this.editedIndex > -1) {
        try {
          let { data } = await axios({
            method: "post",
            url: "/app/updateUser",
            data: this.editedItem
          });
          console.log(data);
          this.text = "User Edited";
          this.snackbar = true;
          Object.assign(this.dataDirectories[this.editedIndex], this.editedItem);
          this.close();
        } catch (e) {
          this.text = "Failed";
          this.snackbar = true;
        }
      } else {
        try {
          let { data } = await axios({
            method: "post",
            url: "/api/directories",
            data: this.editedItem
          });
          this.text = "New User Added";
          this.snackbar = true;
          this.dataDirectories.push(data);
          this.close();
        } catch (e) {
          this.text = "Failed";
          this.snackbar = true;
        }
      }
    },
    // edit(index, item) {
    //   if (!this.editing) {
    //     this.editing = item;
    //     this.index = index;
    //   } else {
    //     this.editing = null;
    //     this.index = -1;
    //   }
    // },
    filter(item, queryText, itemText) {
      if (item.header) return false;

      const hasValue = val => (val != null ? val : "");

      const text = hasValue(itemText);
      const query = hasValue(queryText);

      return (
        text
          .toString()
          .toLowerCase()
          .indexOf(query.toString().toLowerCase()) > -1
      );
    }
  }
};
</script>