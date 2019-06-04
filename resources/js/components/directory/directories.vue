<template>
    <v-content>
        <v-container fluid fill-height>
            <v-layout justify-center row>
                <v-flex xs12>
                    <v-toolbar flat color="white">
                        <v-toolbar-title>User List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New User</v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <v-flex xs12 sm12 md12>
                                                <v-text-field
                                                    v-model="editedItem.name"
                                                    label="Full Name"
                                                    :rules="[v => !!v || 'Name is required']"
                                                    required
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12>
                                                <v-text-field
                                                    v-model="editedItem.username"
                                                    label="Position"
                                                    :rules="[v => !!v || 'Position is required']"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12>
                                                <v-combobox
                                                    v-model="model"
                                                    :filter="filter"
                                                    :hide-no-data="!search"
                                                    :items="items"
                                                    :search-input.sync="search"
                                                    hide-selected
                                                    label="Search for an option"
                                                    multiple
                                                    small-chips
                                                    solo
                                                >
                                                    <template v-slot:no-data>
                                                    <v-list-tile>
                                                        <span class="subheading">Create</span>
                                                        <v-chip
                                                        :color="`${colors[nonce - 1]} lighten-3`"
                                                        label
                                                        small
                                                        >
                                                        {{ search }}
                                                        </v-chip>
                                                    </v-list-tile>
                                                    </template>
                                                    <template v-slot:selection="{ item, parent, selected }">
                                                    <v-chip
                                                        v-if="item === Object(item)"
                                                        :color="`${item.color} lighten-3`"
                                                        :selected="selected"
                                                        label
                                                        small
                                                    >
                                                        <span class="pr-2">
                                                        {{ item.text }}
                                                        </span>
                                                        <v-icon
                                                        small
                                                        @click="parent.selectItem(item)"
                                                        >close</v-icon>
                                                    </v-chip>
                                                    </template>
                                                    <template v-slot:item="{ index, item }">
                                                    <v-list-tile-content>
                                                        <v-text-field
                                                        v-if="editing === item"
                                                        v-model="editing.text"
                                                        autofocus
                                                        flat
                                                        background-color="transparent"
                                                        hide-details
                                                        solo
                                                        @keyup.enter="edit(index, item)"
                                                        ></v-text-field>
                                                        <v-chip
                                                        v-else
                                                        :color="`${item.color} lighten-3`"
                                                        dark
                                                        label
                                                        small
                                                        >
                                                        {{ item.text }}
                                                        </v-chip>
                                                    </v-list-tile-content>
                                                    <v-spacer></v-spacer>
                                                    <v-list-tile-action @click.stop>
                                                        <v-btn
                                                        icon
                                                        @click.stop.prevent="edit(index, item)"
                                                        >
                                                        <v-icon>{{ editing !== item ? 'edit' : 'check' }}</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                                    </template>
                                                </v-combobox>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12>
                                                <v-text-field :rules="emailRules" v-model="editedItem.email" label="Email"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm12s md12 v-if="edit">
                                                <v-text-field
                                                    v-model="editedItem.password"
                                                    :rules="passwordRules"
                                                    label="Password"
                                                    type="password"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12>
                                                <v-select
                                                    v-model="editedItem.userType"
                                                    :items="userType"
                                                    :rules="[v => !!v || 'User type is required']"
                                                    label="User Type"
                                                    required
                                                ></v-select>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                                    <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                    <v-data-table :headers="headers" :items="dataUser" class="elevation-1">
                        <template v-slot:items="props">
                            <td>{{ props.item.id }}</td>
                            <td>{{ props.item.name }}</td>
                            <td>{{ props.item.email }}</td>
                            <td>{{ props.item.userType }}</td>
                            <td class="justify-center layout px-0">
                                <v-icon small class="mr-2" @click="editItem(props.item)" color="primary">edit</v-icon>

                                <!-- <v-icon
                        small
                        @click="deleteItem(props.item)"
                    >
                        delete
                                </v-icon>-->
                            </td>
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
        snackbar: false,
        y: "top",
        x: null,
        mode: "",
        timeout: 6000,
        text: "Hello, I'm a snackbar",
        edit: true,
        dialog: false,
        dataUser: [],
        userType: ["Admin", "Supervisor", "Team Leader", "Operator", "Ban"],

        headers: [
            { text: "ID", align: "left", value: "id" },
            {
                text: "Name",
                value: "name"
            },
            { text: "Email", value: "email" },
            { text: "Type", value: "type" }
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
            userType: ""
        },
        defaultItem: {},
         activator: null,
      attach: null,
      colors: ['green', 'purple', 'indigo', 'cyan', 'teal', 'orange'],
      editing: null,
      index: -1,
      items: [
        { header: 'Select an option or create one' },
        {
          text: 'Foo',
          color: 'blue'
        },
        {
          text: 'Bar',
          color: 'red'
        }
      ],
      nonce: 1,
      menu: false,
      model: [
        {
          text: 'Foo',
          color: 'blue'
        }
      ],
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
      model (val, prev) {
        if (val.length === prev.length) return

        this.model = val.map(v => {
          if (typeof v === 'string') {
            v = {
              text: v,
              color: this.colors[this.nonce - 1]
            }

            this.items.push(v)

            this.nonce++
          }

          return v
        })
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
                    url: "/api/users"
                });
                this.dataUser = data;
            } catch (e) {}
        },

        editItem(item) {
            this.edit = false;
            this.editedIndex = this.dataUser.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            const index = this.dataUser.indexOf(item);
            confirm("Are you sure you want to delete this item?") &&
                this.dataUser.splice(index, 1);
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
                    Object.assign(this.dataUser[this.editedIndex], this.editedItem);
                    this.close();
                } catch (e) {
                    this.text = "Failed";
                    this.snackbar = true;
                }
            } else {
                try {
                    let { data } = await axios({
                        method: "post",
                        url: "/api/users",
                        data: this.editedItem
                    });
                    this.text = "New User Added";
                    this.snackbar = true;
                    this.dataUser.unshift(this.editedItem);
                    this.close();
                } catch (e) {
                    this.text = "Failed";
                    this.snackbar = true;
                }
            }
        },
        edit (index, item) {
        if (!this.editing) {
          this.editing = item
          this.index = index
        } else {
          this.editing = null
          this.index = -1
        }
      },
      filter (item, queryText, itemText) {
        if (item.header) return false

        const hasValue = val => val != null ? val : ''

        const text = hasValue(itemText)
        const query = hasValue(queryText)

        return text.toString()
          .toLowerCase()
          .indexOf(query.toString().toLowerCase()) > -1
      }
    }
};
</script>